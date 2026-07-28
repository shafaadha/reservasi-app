<?php

namespace App\Services\Contracts;

use App\Models\Room;

interface ReservationServiceInterface
{
    public function checkRoomAvailability(array $data);

    public function calculateTotalPrice(Room $room, array $data);

    public function createReservation(array $data);

    public function getReservationByUserId(int $userId);
}
