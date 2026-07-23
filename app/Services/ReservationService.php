<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Services\Contracts\ReservationServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

            $roomUnit = $this->checkRoomAvailability($data);

            $totalPrice = $this->calculateTotalPrice($roomUnit->room, $data);

            return Reservation::create([
                'user_id' => auth()->id(),
                'hotel_id' => $data['hotel_id'],
                'room_unit_id' => $roomUnit->id,
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);
        });
    }

    public function checkRoomAvailability(array $data)
    {
        //get room
        $room = Room::findOrFail($data['room_id']);


        //get reservation data that relate to room
        $availableRoomUnit = $room->roomUnits()->whereDoesntHave('reservations', function ($query) use ($data) {
            $query->whereIn('status', [
                'pending',
                'confirmed',
                'check_in'
            ])->where('check_in', '<', $data['check_in'])
                ->where('check_out', '>', $data['check_out']);
        })->first();

        if (!$availableRoomUnit) {
            throw new \Exception('Room is not available', 409);
        }

        return $availableRoomUnit;
    }


    public function calculateTotalPrice(RoomUnit $room, array $data)
    {
        //calculate days
        $days = Carbon::parse($data['check_in'])->diffInDays($data['check_out']);

        $totalPrice = $days * $room->price;

        return $totalPrice;
    }
}
