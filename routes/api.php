<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);
Route::get('/hotels', [HotelController::class,'index']);

Route::apiResource('reservations', ReservationController::class);