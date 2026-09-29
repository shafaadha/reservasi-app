<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RoomUnit;
use App\Services\Contracts\RoomUnitServiceInterface;
use Illuminate\Http\Request;

class RoomUnitController extends Controller
{
    protected RoomUnitServiceInterface $roomUnitService;

    public function __construct(RoomUnitServiceInterface $roomUnitService)
    {
        $this->roomUnitService = $roomUnitService;
    }

    public function index()
    {
        $totalUnit = RoomUnit::count();

        $availableUnit = RoomUnit::where('status', 'available')->count();

        $resToday = Reservation::whereDate('check_in', today())->count();

        $occupiedUnit = RoomUnit::where('status', 'available')->count();

        $revenueToday = Reservation::whereDate('check_in', today())
            ->where('status', 'confirmed')
            ->sum('total_price');

        // $roomUnits = RoomUnit::with('latestPaidReservation')->paginate(10);

        return response()->json([
            'summary' => [
                'totalUnit' => $totalUnit,
                'availableUnit' => $availableUnit,
                'occupiedUnit' => $occupiedUnit,
                'resToday' => $resToday,
                'revToday' => $revenueToday,
            ],

            'latestReservations' => Reservation::with([
                'user',
                'roomUnits',
                'payment',
            ])->where('hotel_id', auth()->user()->hotel_id)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function roomReservation()
    {
        $rooms = RoomUnit::with('reservation')->get();
    }

    public function room(Request $request)
    {
        // $hotelId = auth()->user()->hotel_id;

        // $perPage = $request->integer('per_page', 10);

        $hotelId = 1;

        $roomUnits = $this->roomUnitService->getAllRoomUnit(
            $hotelId,
        );

        return response()->json([
            'message' => 'Success',
            'data' => $roomUnits,
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
