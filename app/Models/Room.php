<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'name',
        'type',
        'capacity',
        'quantity',
        'price',
        'description',
    ];

    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
}
