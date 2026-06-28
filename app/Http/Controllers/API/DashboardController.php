<?php

namespace App\Http\Controllers\API;

use App\Models\Reservation;
use App\Models\RoomUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = RoomUnit::orderBy('room_number')->get();
        // $emptyUnit = RoomUnit::where('status', 'available')->orderBy('room_number')->get();
        $totalUnit = RoomUnit::count();

        $resToday = Reservation::where('check_in', today());

        return response()->json([
            'rooms' => $rooms,
            // 'emptyRoom' => $emptyUnit,
            'resToday' => $resToday,
            'totalUnit' => $totalUnit,
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
