<?php

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConnectionRefController;
use App\Http\Controllers\SpecializationController;

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::resource([
    'doctors' => DoctorController::class,
    'specializations' => SpecializationController::class,
    'clinics' => ClinicController::class,
    'services' => ServiceController::class,
    'appointments' => AppointmentController::class,
    'connections' => ConnectionController::class,
    'connection-refs' => ConnectionRefController::class,
    'schedule' => ScheduleController::class,
]);

Route::get('/test', function(Request $request) {
    return Appointment::find(4)->service;
});
