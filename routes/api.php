<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'rooms'], function () {
    Route::get('/', [RoomController::class, 'index' ]);
    Route::post('/create', [RoomController::class, 'create']);
    Route::get('/{id}/view', [RoomController::class, 'view']);
    Route::post('{id}/update', [RoomController::class, 'update']);
    Route::post('{id}/delete', [RoomController::class, 'delete']);
});

Route::group(['prefix' => 'reservations'], function() {
    Route::get('/', [ReservationController::class, 'index']);
    Route::post('create', [ReservationController::class, 'create']);
    Route::post('{id}/update', [ReservationController::class, 'update']);
    Route::post('{id}/delete', [ReservationController::class, 'delete']);
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

//rooms
//rooms/create
//rooms/id
//rooms/id/reservations
//rooms/id/edit
//rooms/id/delete
//
//reservations
//reservations/create
//reservations/id/edit
//reservations/id/delete
//
//users/create
//users/id/edit
//users/id/delete


