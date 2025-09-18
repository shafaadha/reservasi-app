<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);
Route::get('/hotels', [HotelController::class,'index']);

Route::get('/config', function(){
    return response()->json([
        'unsplash_access_key'=>env('UNSPLASH_ACCESS_KEY'),
    ]
    );
});
Route::post('/room/check-availability', [RoomController::class, 'checkAvailability']);

Route::apiResource('reservations', ReservationController::class);