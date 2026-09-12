<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Room;
use App\Services\Contracts\RoomServiceInterface;
use Carbon\Carbon;

class RoomService implements RoomServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    //for get Room Hotel that still exist
    public function getAvailabilityRoom(array $data)
    {

        $checkin = Carbon::parse($data['checkin']);
        $checkout = Carbon::parse($data['checkout']);
        $guest    = $data['guest'];
        $roomNeed = $data['room'];


        if ($checkout->lte($checkin)) {
            throw new \Exception('Check out date must be after check in date.', 422);
        }

        if ($checkin->lt(Carbon::today())) {
            throw new \Exception('Check-in date must be today or later.', 422);
        }

        if ($guest < 1) {
            throw new \Exception('Quest must be at least 1', 422);
        }

        if ($roomNeed < 1) {
            throw new \Exception('Room must be at least 1', 422);
        }

        $rooms = Room::with('hotel')->get();

        $availableRooms = $rooms->filter(function ($room) use ($checkin, $checkout, $guest, $roomNeed) {

            $totalCapacity = $room->capacity * $roomNeed;

            if ($totalCapacity < $guest) {
                return false;
            }

            $availableUnits = $room->roomUnits()
                ->whereDoesntHave('reservations', function ($query) use ($checkin, $checkout) {
                    $query->whereIn('status', ['pending', 'confirmed'])
                        ->where('check_in', '<', $checkout)
                        ->where('check_out', '>', $checkin);
                })
                ->count();

            return $availableUnits >= $roomNeed;
        });

        return $availableRooms->values();
    }
}
