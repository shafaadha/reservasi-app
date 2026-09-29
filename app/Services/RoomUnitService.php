<?php

namespace App\Services;

use App\Models\RoomUnit;
use App\Services\Contracts\RoomUnitServiceInterface;

class RoomUnitService implements RoomUnitServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function updateStatus(array $roomUnits)
    {
        RoomUnit::whereIn('id', $roomUnits)
            ->update([
                'status' => 'occupied',
            ]);
    }

    public function getAllRoomUnit(int $hotelId)
    {
        return RoomUnit::with([
            'room',
            'currentReservation.user',
        ])
            ->whereHas('room', function ($query) use ($hotelId) {
                $query->where('hotel_id', $hotelId);
            })->get();
    }
}
