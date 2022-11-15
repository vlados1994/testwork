<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UsersController::class, 'getAll']);
    Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);

    Route::get('/services', [ServicesController::class, 'getAll']);

    Route::get('/schedules', [ScheduleController::class, 'getAll']);
    Route::post('/schedules', [ScheduleController::class, 'setSchedule']);
});

