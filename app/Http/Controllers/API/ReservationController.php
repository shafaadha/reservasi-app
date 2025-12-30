<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Container\Attributes\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::orderBy('date')->orderBy('time')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id' => 'required',
            'room_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'room_booked' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $room = Room::findOrFail($request->room_id);

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'hotel_id' => $request->hotel_id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'room_booked' => $request->room_booked,
            'total_price' => $request->total_price,
            'status' => 'confirmed',
        ]);
        return response()->json([
            'message' => 'Booking berhasil',
            'reservation' => $reservation
        ], 201);
    }

    public function myReservations()
    {
        return Reservation::where('user_id', auth()->id())->get();
    }
}
