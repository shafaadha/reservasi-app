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

    public function getAllRoomUnit(int $hotelId)
    {
        return RoomUnit::with('room')
            ->whereHas('room', function ($query) use ($hotelId) {
                $query->where('hotel_id', $hotelId);
            })
            ->get();
    }
}
