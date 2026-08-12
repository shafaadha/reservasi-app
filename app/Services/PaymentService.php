<?php

namespace App\Services;

use App\Models\Payment;
use App\Services\Contracts\PaymentServiceInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService implements PaymentServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function showByReservationId(int $reservationId)
    {
        return Payment::with([
            'reservation.user',
            'reservation.hotel',
            'reservation.roomUnits.room',
        ])
            ->where('reservation_id', $reservationId)
            ->firstOrFail();
    }

    public function handleWebhook(string $orderId): Payment
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode(env('MIDTRANS_SERVER_KEY').':'),
        ])->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

        if (! $response->successful()) {
            throw new Exception(
                'Failed to fetch transaction from Midtrans'
            );
        }
        $data = $response->json();

        if (! isset($data['transaction_status'])) {
            Log::error('Invalid response from Midtrans', $data);

            throw new Exception(
                'Invalid response from Midtrans'
            );
        }

        $payment = Payment::where(
            'order_id',
            $orderId
        )->first();

        if (! $payment) {
            throw new Exception(
                "Payment not found: {$orderId}"
            );
        }

        if (in_array($payment->status, [
            'settlement',
            'capture',
        ])) {
            return $payment;
        }

        $payment->status = match ($data['transaction_status']) {
            'capture' => 'capture',
            'settlement' => 'settlement',
            'pending' => 'pending',
            'deny' => 'deny',
            'expire' => 'expire',
            'cancel' => 'cancel',
            default => 'pending',
        };

        if ($data['transaction_status'] === 'expire') {
            $payment->update([
                'status' => 'expired',
            ]);

            $payment->reservation->update([
                'status' => 'cancelled',
            ]);
        }

        if (
            $data['transaction_status'] === 'settlement'
            && ! $payment->paid_at
        ) {
            $payment->paid_at = now();
        }

        $payment->transaction_id =
            $data['transaction_id'] ?? null;

        $payment->payment_type =
            $data['payment_type'] ?? null;

        $payment->save();

        return $payment;

    }
}
