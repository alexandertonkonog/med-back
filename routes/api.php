<?php

use App\Models\Doctor;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ServiceController;

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(AuthMiddleware::class)->get('me', [AuthController::class, 'me']);
});

Route::group([
    'prefix' => 'doctors',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::get('/', [DoctorController::class, 'select']);
    Route::post('create', [DoctorController::class, 'create']);
});

Route::group([
    'prefix' => 'services',
    'middleware' => AuthMiddleware::class
], function ($router) {
    Route::get('/', [ServiceController::class, 'select']);
    Route::post('create', [ServiceController::class, 'create']);
});

Route::get('/test', function(Request $request) {
    return Doctor::with('img')->where('id', 50)->get();
});
