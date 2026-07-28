<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Services\Contracts\ReservationServiceInterface;

class ReservationController extends Controller
{
    protected ReservationServiceInterface $reservationService;

    public function __construct(ReservationServiceInterface $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        return Reservation::with([
            'user',
            'hotel',
            'roomUnit.room',
            'payment',
        ])->where('hotel_id', auth()->user()->hotel_id)->latest()->get();
    }

    public function store(StoreReservationRequest $request)
    {

        $reservation = $this->reservationService->createReservation($data = $request->validated());

        $roomNumber = $reservation->roomUnits->pluck('room_number')->toArray();

        return response()->json([
            'message' => 'Booking success',
            'reservation' => $reservation,
            'room_number' => $roomNumber,
        ]);
    }

    public function myReservations()
    {
        $reservations = $this->reservationService->getReservationByUserId(auth()->id());

        return response()->json($reservations);
    }
}
