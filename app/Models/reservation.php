<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_id',
        'room_unit_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roomUnits()
    {
        return $this->belongsToMany(
            RoomUnit::class,
            'reservation_rooms',
            'reservation_id',
            'room_unit_id'
        );
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function reservationRoom()
    {
        return $this->hasMany(ReservationRoom::class);
    }
}
