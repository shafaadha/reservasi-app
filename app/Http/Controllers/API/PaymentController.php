<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use App\Services\Contracts\PaymentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected PaymentServiceInterface $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function create(Request $request)
    {
        $reservation = Reservation::with('user')->findOrFail($request->reservation_id);
        $orderId = (string) Str::uuid();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) round($reservation->total_price),
            ],
            'item_details' => [
                [
                    'id' => $reservation->id,
                    'price' => (int) round($reservation->total_price),
                    'quantity' => 1,
                    'name' => 'Reservasi Hotel',
                ],
            ],
            'customer_details' => [
                'first_name' => $reservation->user->name,
                'email' => $reservation->user->email,
                'phone' => $reservation->user->phone_number ?? '0',
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic '.base64_encode(env('MIDTRANS_SERVER_KEY').':'),
            'Accept' => 'application/json',
        ])->post(
            env('MIDTRANS_IS_PRODUCTION')
                ? 'https://app.midtrans.com/snap/v1/transactions'
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions',
            $params
        );

        $data = $response->json();

        if (! $response->successful()) {
            return response()->json($data, $response->status());
        }

        Payment::create([
            'reservation_id' => $reservation->id,
            'order_id' => $orderId,
            'amount' => $reservation->total_price,
            'payment_type' => null,
            'transaction_id' => null,
            'snap_token' => $data['token'],
            'status' => 'pending',
        ]);

        return response()->json([
            'token' => $data['token'],
            'redirect_url' => $data['redirect_url'],
        ]);
    }

    public function webHook(Request $request)
    {
        Log::info('Midtrans payment', $request->all());

        if (! $request->filled('order_id')) {
            return response()->json([
                'message' => 'order_id is required',
            ]);
        }

        try {
            $this->paymentService->handleWebhook(
                $request->order_id
            );

            return response()->json([
                'message' => 'OK',
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Midtrans webhook error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Webhook processing failed',
            ], 500);
        }

    }

    public function show($reservationId)
    {
        $payment = $this->paymentService->showByReservationId($reservationId);

        return response()->json([
            'message' => 'Success',
            'data' => $payment,
        ]);
    }
}
