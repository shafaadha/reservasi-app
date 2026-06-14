<?php

namespace App\Http\Controllers\API;

use App\Models\RoomUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;

class RoomUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalUnit = RoomUnit::count();

        $availableUnit = RoomUnit::where('status', 'available')->count();

        $occupiedUnit = RoomUnit::where('status', 'occupied')->count();

        $resToday = Reservation::whereDate('check_in', today())->count();

        $revenueToday = Reservation::whereDate('check_in', today())
            ->where('status', 'confirmed')
            ->sum('total_price');

        return response()->json([
            'totalUnit' => $totalUnit,
            'availableUnit' => $availableUnit,
            'occupiedUnit' => $occupiedUnit,
            'resToday' => $resToday,
            'revToday' => $revenueToday
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomUnit $roomUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomUnit $roomUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomUnit $roomUnit)
    {
        //
    }
}
