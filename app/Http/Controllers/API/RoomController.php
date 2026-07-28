<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use App\Services\Contracts\RoomServiceInterface;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected RoomServiceInterface $roomService;

    public function __construct(RoomServiceInterface $roomService)
    {
        $this->roomService = $roomService;
    }

    public function checkAvailability(Request $request)
    {

        try {
            $availableRooms = $this->roomService->getAvailabilityRoom($request->validated());

            return response()->json([
                'total_rooms' => Room::count(),
                'available_rooms' => $availableRooms->count(),
                'data' => $availableRooms,
            ]);
        } catch (\Throwable $e) {
            dd([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'type' => gettype($e->getCode()),
                'class' => get_class($e),
            ]);
        }
    }

    public function roomList(User $user)
    {

        $hotelId = auth()->hotel_id;
        $room = Room::where('id', $hotelId)->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
