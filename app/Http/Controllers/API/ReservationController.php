<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\Contracts\ReservationServiceInterface;
use Carbon\Carbon;

class ReservationController extends Controller
{

    protected ReservationServiceInterface $reservationService;

    public function index()
    {
        return Reservation::with([
            'user',
            'hotel',
            'roomUnit.room',
            'payment'
        ])->where('hotel_id', auth()->user()->hotel_id)->latest()->get();
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

        $reservation = $this->reservationService->createReservation($data);

        return response()->json([
            'message' => 'Booking success',
            'reservation' => $reservation,
            'room_number' => $reservation->roomUnit->room_number,
        ]);
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
