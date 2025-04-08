<?php

use Illuminate\Support\Facades\Route;
use Udhuong\PassportAuth\Presentation\Http\Controllers\AuthController;
use Udhuong\PassportAuth\Presentation\Http\Controllers\ClientCredentialController;

Route::prefix('api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('refresh', [AuthController::class, 'refreshToken']);
    });
    Route::prefix('client-credential')->group(function () {
        Route::post('get-token', [ClientCredentialController::class, 'getToken']);
    });
    Route::middleware('auth:api')->group(function () {
        Route::get('user', [AuthController::class, 'getUserLogged']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
