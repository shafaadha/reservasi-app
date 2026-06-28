<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomUnit;
use Carbon\Carbon;
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
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($data['room_id']);

        $availableUnit = $room->roomUnits()
            ->whereDoesntHave('reservations', function ($query) use ($data) {
                $query->whereIn('status', [
                    'pending',
                    'confirmed',
                    'checked_in'
                ])
                    ->where('check_in', '<', $data['check_out'])
                    ->where('check_out', '>', $data['check_in']);
            })
            ->first();

        if (!$availableUnit) {
            return response()->json([
                'message' => 'Tidak ada kamar tersedia'
            ], 422);
        }

        $days = Carbon::parse($data['check_in'])
            ->diffInDays($data['check_out']);

        $totalPrice = $days * $room->price;

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'hotel_id' => $data['hotel_id'],
            'room_unit_id' => $availableUnit->id,
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'guests' => $data['guests'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking success',
            'reservation' => $reservation,
            'room_number' => $availableUnit->room_number,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'hotel_id' => 'required|exists:hotels,id',
    //         'room_id' => 'required|exists:rooms,id',
    //         'check_in' => 'required|date',
    //         'check_out' => 'required|date|after:check_in',
    //         'guests' => 'required|integer|min:1',
    //     ]);
    //     $room = Room::findOrFail($data['room_id']);


    //     $availableUnit = $room->roomUnits()
    //         ->whereDoesntHave('reservations', function ($query) use ($data) {
    //             $query->whereIn('status', [
    //                 'pending',
    //                 'confirmed',
    //                 'checked_in'
    //             ])
    //                 ->where('check_in', '<', $data['check_out'])
    //                 ->where('check_out', '>', $data['check_in']);
    //         })
    //         ->first();

    //     if (!$availableUnit) {
    //         return response()->json([
    //             'message' => 'Tidak ada kamar tersedia'
    //         ], 422);
    //     }

    //     $days = \Carbon\Carbon::parse($data['check_in'])
    //         ->diffInDays($data['check_out']);

    //     $totalPrice = $days * $room->price;

    //     // $isBooked = Reservation::where('room_unit_id', $data['room_unit_id'])
    //     //     ->whereIn('status', [
    //     //         'pending',
    //     //         'confirmed',
    //     //         'checked_in'
    //     //     ])
    //     //     ->where(function ($query) use ($data) {

    //     //         $query->whereBetween('check_in', [
    //     //             $data['check_in'],
    //     //             $data['check_out']
    //     //         ])
    //     //             ->orWhereBetween('check_out', [
    //     //                 $data['check_in'],
    //     //                 $data['check_out']
    //     //             ])
    //     //             ->orWhere(function ($q) use ($data) {

    //     //                 $q->where('check_in', '<=', $data['check_in'])
    //     //                     ->where('check_out', '>=', $data['check_out']);
    //     //             });
    //     //     })
    //     //     ->exists();

    //     // if ($isBooked) {

    //     //     return response()->json([
    //     //         'message' => 'Room has been booked'
    //     //     ], 422);
    //     // }

    //     $reservation = Reservation::create([
    //         'user_id' => auth()->id(),
    //         'hotel_id' => $data['hotel_id'],
    //         'room_unit_id' => $availableUnit->id,
    //         'check_in' => $data['check_in'],
    //         'check_out' => $data['check_out'],
    //         'guests' => $data['guests'],
    //         'total_price' => $totalPrice,
    //         'status' => 'pending',
    //     ]);
    //     return response()->json([
    //         'message' => 'Booking success',
    //         'reservation' => $reservation,
    //         'room_number' => $availableUnit->room_number,
    //     ]);
    // }

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
