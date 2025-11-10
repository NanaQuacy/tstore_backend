<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Version 1
Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register-with-business', [AuthController::class, 'registerWithBusiness']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Business routes
        Route::apiResource('businesses', \App\Http\Controllers\BusinessController::class);
        Route::post('/businesses/{business}/users', [\App\Http\Controllers\BusinessController::class, 'addUser']);
        Route::delete('/businesses/{business}/users', [\App\Http\Controllers\BusinessController::class, 'removeUser']);
    });
});
