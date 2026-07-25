<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationRoom extends Model
{
    protected $fillable = [
        'reservation_id',
        'room_unit_id',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function roomUnit()
    {
        return $this->belongsTo(RoomUnit::class);
    }
}
