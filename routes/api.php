<?php

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ConnectionRefController;
use App\Http\Controllers\SpecializationController;

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(AuthMiddleware::class)->get('me', [AuthController::class, 'me']);
});

Route::group([
    'prefix' => 'get'
], function ($router) {
    Route::get('/doctors', [DoctorController::class, 'select']);
    Route::get('/services', [ServiceController::class, 'select']);
    Route::get('/specializations', [SpecializationController::class, 'select']);
    Route::get('/clinics', [ClinicController::class, 'select']);
    Route::get('/connections', [ConnectionController::class, 'select']);
    Route::get('/connection-refs', [ConnectionRefController::class, 'select']);
});

Route::group([
    'prefix' => 'doctors',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::post('create', [DoctorController::class, 'create']);
    Route::post('delete', [DoctorController::class, 'delete']);
    Route::post('update', [DoctorController::class, 'update']);
});

Route::group([
    'prefix' => 'services',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::post('create', [ServiceController::class, 'create']);
    Route::post('delete', [ServiceController::class, 'delete']);
    Route::post('update', [ServiceController::class, 'update']);
});

Route::group([
    'prefix' => 'specializations',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::post('create', [SpecializationController::class, 'create']);
    Route::post('delete', [SpecializationController::class, 'delete']);
    Route::post('update', [SpecializationController::class, 'update']);
});

Route::group([
    'prefix' => 'clinics',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::post('create', [ClinicController::class, 'create']);
    Route::post('delete', [ClinicController::class, 'delete']);
    Route::post('update', [ClinicController::class, 'update']);
});

Route::group([
    'prefix' => 'connections',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::post('create', [ConnectionController::class, 'create']);
    Route::post('delete', [ConnectionController::class, 'delete']);
    Route::post('update', [ConnectionController::class, 'update']);
});

Route::group([
    'prefix' => 'connection-refs',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::post('create', [ConnectionRefController::class, 'create']);
    Route::post('delete', [ConnectionRefController::class, 'delete']);
    Route::post('update', [ConnectionRefController::class, 'update']);
});

Route::get('/test', function(Request $request) {
    $entity = Clinic::find(105);
    return $entity->withAll();
});
