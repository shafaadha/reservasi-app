<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    protected $fillable = ['name', 'email', 'date', 'time', 'guests'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }

}
