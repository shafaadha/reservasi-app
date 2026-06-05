<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RoomUnit;
use Illuminate\Container\Attributes\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::with([
            'user',
            'hotel',
            'roomUnit.room'
        ])->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_unit_id' => 'required|exists:room_units,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $roomUnit = RoomUnit::with('room')
            ->findOrFail($data['room_unit_id']);

        $isBooked = Reservation::where('room_unit_id', $data['room_unit_id'])
            ->whereIn('status', [
                'pending',
                'confirmed',
                'checked_in'
            ])
            ->where(function ($query) use ($data) {

                $query->whereBetween('check_in', [
                    $data['check_in'],
                    $data['check_out']
                ])
                    ->orWhereBetween('check_out', [
                        $data['check_in'],
                        $data['check_out']
                    ])
                    ->orWhere(function ($q) use ($data) {

                        $q->where('check_in', '<=', $data['check_in'])
                            ->where('check_out', '>=', $data['check_out']);
                    });
            })
            ->exists();

        if ($isBooked) {

            return response()->json([
                'message' => 'Room has been booked'
            ], 422);
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'hotel_id' => $data['hotel_id'],
            'room_id' => $data['room_id'],
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'guests' => $data['guests'],
            'room_booked' => $data['room_booked'],
            'total_price' => $data['total_price'],
            'status' => 'pending',
        ]);
        return response()->json([
            'message' => 'Booking success',
            'reservation' => $reservation
        ], 201);
    }

    public function myReservations()
    {
        return Reservation::with([
            'hotel',
            'roomUnit.room'
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }
}
