<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\Room;
use App\Services\Contracts\ReservationServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class ReservationService implements ReservationServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createReservation(array $data)
    {
        return DB::transaction(function () use ($data) {

            $roomUnits = $this->checkRoomAvailability($data);

            $totalPrice = $this->calculateTotalPrice(
                $roomUnits->first()->room,
                $data
            );

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'hotel_id' => $data['hotel_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($roomUnits as $roomUnit) {
                ReservationRoom::create([
                    'reservation_id' => $reservation->id,
                    'room_unit_id' => $roomUnit->id,
                ]);
            }

            // return $reservation;
            return $reservation->load([
                'roomUnits',
                'user',
                'hotel',
            ]);
        });
    }

    public function checkRoomAvailability(array $data)
    {
        $room = Room::findOrFail($data['room_id']);

        $availableRoomUnits = $room->roomUnits()
            ->where('status', '!=', 'maintenance')
            ->whereDoesntHave('reservations', function ($query) use ($data) {
                $query->whereIn('status', [
                    'pending',
                    'confirmed',
                    'checked_in',
                ])
                    ->where('check_in', '<', $data['check_out'])
                    ->where('check_out', '>', $data['check_in']);
            })
            ->lockForUpdate()
            ->limit($data['room_count'])
            ->get();

        if ($availableRoomUnits->count() < $data['room_count']) {
            throw ValidationValidationException::withMessages([
                'room_count' => 'Available rooms are not sufficient.',
            ]);
        }

        return $availableRoomUnits;
    }

    public function calculateTotalPrice(Room $room, array $data)
    {
        // calculate days
        $days = Carbon::parse($data['check_in'])->diffInDays($data['check_out']);

        $totalPrice = $days * $room->price;

        return $totalPrice;
    }

    public function getReservationByUserId(int $userId)
    {
        return Reservation::with([
            'hotel',
            'roomUnits.room',
            'payment',
        ])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function getHotelReservations(int $hotelId)
    {
        return Reservation::with([
            'user',
            'payment',
            'roomUnits.room',
            'hotel',
        ])
            ->where('hotel_id', $hotelId)
            ->latest()
            ->get();
    }
}
