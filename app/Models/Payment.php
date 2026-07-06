<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'order_id',
        'transaction_id',
        'amount',
        'payment_type',
        'snap_token',
        'status',
        'paid_at',
    ];
}
