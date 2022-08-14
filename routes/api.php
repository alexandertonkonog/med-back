<?php

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::apiResources([
    'doctors' => DoctorController::class,
    'specializations' => SpecializationController::class,
    'clinics' => ClinicController::class,
    'services' => ServiceController::class,
    'appointments' => AppointmentController::class,
    'connections' => ConnectionController::class,
    'connection-refs' => ConnectionRefController::class,
    'schedule' => ScheduleController::class,
]);

Route::get('/test', function() {

});
