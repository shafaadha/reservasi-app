<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillabe = ['name'];

    public function room(){
        return $this->hasMany(Room::class);
    }
    public function reservasi(){
        return $this->hasMany(Reservation::class);
    }
}
