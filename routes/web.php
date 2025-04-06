<?php

use Illuminate\Support\Facades\Route;
use Udhuong\PassportAuth\Presentation\Http\Controllers\SocialAuthController;

Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [SocialAuthController::class, 'redirect']);
    Route::get('{provider}/callback', [SocialAuthController::class, 'callback']);
});
