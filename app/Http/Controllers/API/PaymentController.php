<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // public function create(Request $request)
    // {
    //     $reservation = Reservation::findOrFail($request->reservation_id);
    //     $orderId = Str::uuid();
    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $orderId,
    //             'gross_amount' => $reservation->total_price,
    //         ],
    //         'item_details' => [
    //             [
    //                 'id' => $reservation->id,
    //                 'price' => $reservation->total_price,
    //                 'quantity' => 1,
    //                 'name' => 'Reservasi Hotel',
    //             ]
    //         ],
    //         'customer_details' => [
    //             'first_name' => $reservation->user->name,
    //             'email' => $reservation->user->email,
    //         ]
    //         // 'enabled_payments' => array('credit_card',  'bca_va', 'bni_va', 'bri_va')
    //     ];

    //     $auth = base64_encode(env('MIDTRANS_SERVER_KEY' . ':'));

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Basic ' . base64_encode(env('MIDTRANS_SERVER_KEY') . ':'),
    //         'Accept' => 'application/json',
    //     ])->post(
    //         env('MIDTRANS_IS_PRODUCTION')
    //             ? 'https://app.midtrans.com/snap/v1/transactions'
    //             : 'https://app.sandbox.midtrans.com/snap/v1/transactions',
    //         $params
    //     );

    //     $response = json_decode($response->body());

    //     Payment::create([
    //         'reservation_id' => $request->reservation_id,
    //         'order_id' => $orderId,
    //         'amount' => $request->price,
    //         'payment_type' => null,
    //         'snap_token' => $response->token,
    //         'status' => 'pending',
    //     ]);

    //     return response()->json($response);


    //     // save db
    // }

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
                ]
            ],
            'customer_details' => [
                'first_name' => $reservation->user->name,
                'email' => $reservation->user->email,
                'phone' => $reservation->user->phone ?? '0',
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('MIDTRANS_SERVER_KEY') . ':'),
            'Accept' => 'application/json',
        ])->post(
            env('MIDTRANS_IS_PRODUCTION')
                ? 'https://app.midtrans.com/snap/v1/transactions'
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions',
            $params
        );

        $data = $response->json();

        if (!$response->successful()) {
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
        Log::info('Webhook masuk');
        Log::info($request->all());

        if (!$request->filled('order_id')) {
            return response()->json([
                'message' => 'order_id is required'
            ], 200);
        }
        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(env('MIDTRANS_SERVER_KEY') . ':')
        ])->get("https://api.sandbox.midtrans.com/v2/$request->order_id/status");

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Failed to fetch transaction from Midtrans'
            ], 500);
        }
        $response = (object) $response->json();

        if (!isset($response->transaction_status)) {
            Log::error('Invalid response from Midtrans', (array) $response);

            return response()->json([
                'message' => 'Invalid response'
            ], 200);
        }
        $payment = Payment::where('order_id', $response->order_id)->firstOrFail();

        // check db

        if (!$payment) {
            Log::error('Payment tidak ditemukan', [
                'order_id' => $response->order_id
            ]);

            return response()->json([
                'message' => 'Payment not found'
            ], 200);
        }
        if ($payment->status === 'settlement' || $payment->status === 'capture') {
            return response()->json('Payment has been already processed');
        }

        $payment->status = match ($response->transaction_status) {
            'capture' => 'capture',
            'settlement' => 'settlement',
            'pending' => 'pending',
            'deny' => 'deny',
            'expire' => 'expire',
            'cancel' => 'cancel',
            default => 'pending',
        };

        if ($response->transaction_status === 'settlement') {
            $payment->paid_at = now();
        }

        $payment->transaction_id = $response->transaction_id ?? null;
        $payment->payment_type = $response->payment_type ?? null;

        $payment->save();
        return response()->json([
            'message' => 'OK'
        ], 200);
    }
}
