<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'room_number',
        'status',
        'cleaning_status'
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(
            Reservation::class,
            'reservation_rooms',
            'room_unit_id',
            'reservation_id'
        );
    }


    public function roomReservation()
    {
        return $this->belongsTo(ReservationRoom::class);
    }


    public function latestPaidReservation()
    {
        return $this->hasOne(Reservation::class)->latestOfMany();
    }
    // public function latestPaidReservation()
    // {
    //     return $this->hasOne(Reservation::class)
    //         ->ofMany('id', 'max', function ($query) {
    //             $query->whereHas('payment', function ($q) {
    //                 $q->where('status', 'paid');
    //             });
    //         });
    // }
}
