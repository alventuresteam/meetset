<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainInfoController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/{id}/update', [UserController::class, 'update']);
    Route::post('/{id}/delete', [UserController::class, 'delete']);
});


Route::get('/room/{id}', [MainInfoController::class, 'getRoomInfo']);

