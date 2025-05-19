<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('api.login');
Route::post('/register', [\App\Http\Controllers\API\AuthController::class, 'register'])->name('api.register');
Route::post('/forget-password', [\App\Http\Controllers\API\AuthController::class, 'forgetPassword'])->name('api.forget-password');
Route::post('/reset-password', [\App\Http\Controllers\API\AuthController::class, 'resetPassword'])->name('api.reset-password');
Route::post('/send-verification-email', [\App\Http\Controllers\API\AuthController::class, 'sendVerificationEmail'])->name('api.reset-password');
