<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::orderBy('date')->orderBy('time')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email'  => 'required|email',
            'date'   => 'required|date',
            'time'   => 'required',
            'guests' => 'required|integer|min:1'
        ]);

        $reservation = Reservation::create($data);
        return response()->json($reservation,201);
    }
}
