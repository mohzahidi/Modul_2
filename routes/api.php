<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Room Routes
Route::apiResource('/rooms', App\Http\Controllers\Api\RoomController::class);

// Reservation Routes
Route::apiResource('/reservations', App\Http\Controllers\Api\ReservationController::class);