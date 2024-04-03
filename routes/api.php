<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {

    Route::prefix('user')->name('user.')->group(function () {
        Route::post('registration', [AuthController::class, 'registration'])->name('registration');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('app', [AppController::class, 'index']);
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });
});
