<?php

namespace App\Services\Contracts;

use App\Models\RoomUnit;

interface ReservationServiceInterface
{
    public function checkRoomAvailability(array $data);

    public function calculateTotalPrice(RoomUnit $room, array $data);

    public function createReservation(array $data);
}
