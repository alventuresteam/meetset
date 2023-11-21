<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MainInfoController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/{id}/update', [UserController::class, 'update']);
    Route::post('/{id}/delete', [UserController::class, 'delete']);
});

Route::group(['prefix' => 'setting'], function () {
    Route::get('/', [SettingController::class, 'index']);
    Route::post('/update', [SettingController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/update-server', [SettingController::class, 'updateServer'])->middleware('auth:sanctum');
    Route::post('/update-login-page', [SettingController::class, 'updateLoginPage'])->middleware('auth:sanctum');
    Route::post('/update-employer', [SettingController::class, 'updateEmployer'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'logs'], function () {
    Route::get('/', [LogController::class, 'index']);
    Route::get('/export', [LogController::class, 'exportData']);
});

Route::get('/room/{id}', [MainInfoController::class, 'getRoomInfo']);
Route::get('/check/{id}', [MainInfoController::class, 'check']);


Route::get('/ics', [SettingController::class, 'ics']);


Route::post('/import-excel', [ImportController::class, 'importFromExcel'])->middleware('auth:sanctum');
Route::post('/import-ldap', [ImportController::class, 'importFromLdap'])->middleware('auth:sanctum');

Route::get('/contacts', [ContactController::class,'index'])->middleware('auth:sanctum');
Route::get('/search-contacts', [ContactController::class,'search'])->middleware('auth:sanctum');

