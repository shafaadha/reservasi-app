<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\reservation;

class RoomController extends Controller
{
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'checkin'  => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'guest'    => 'required|integer|min:1',
            'room'     => 'required|integer|min:1',
        ]);

        $checkin  = $request->checkin;
        $checkout = $request->checkout;
        $guest    = $request->guest;
        $roomNeed = $request->room;

        if (strtotime($checkout) <= strtotime($checkin)) {
            return response()->json([
                'message' => 'Tanggal check-out harus setelah tanggal check-in.'
            ], 422);
        }

        if(strtotime($checkin) < strtotime(date('Y-m-d'))){
            return response()->json([
                'message' => 'Tanggal check-in harus hari ini atau setelahnya.'
            ], 422);
        }

        if ($guest < 1) {
            return response()->json([
                'message' => 'Jumlah tamu harus minimal 1.'
            ], 422);
        }

        if ($roomNeed < 1) {
            return response()->json([
                'message' => 'Jumlah kamar yang dibutuhkan harus minimal 1.'
            ], 422);
        }

        $rooms = Room::all();

        $availableRooms = $rooms->filter(function ($room) use ($checkin, $checkout, $guest, $roomNeed) {
            if ($room->capacity < $guest) {
                return false;
            }

            $bookedCount = Reservation::where('room_id', $room->id)
                ->where(function ($query) use ($checkin, $checkout) {
                    $query->whereBetween('check_in', [$checkin, $checkout])
                        ->orWhereBetween('check_out', [$checkin, $checkout])
                        ->orWhere(function ($q) use ($checkin, $checkout) {
                            $q->where('check_in', '<=', $checkin)
                                ->where('check_out', '>=', $checkout);
                        });
                })
                ->sum('guests');

            // Hitung kamar tersisa
            $remaining = $room->quantity - $bookedCount;

            // Hanya return kamar yang masih ada stok cukup
            return $remaining >= $roomNeed;
        });

        return response()->json([
            'availableRooms' => $availableRooms->values()
        ]);
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
