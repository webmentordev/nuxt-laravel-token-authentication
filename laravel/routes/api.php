<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EmailController;

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user', [AuthenticationController::class, 'index']);
    Route::delete('/logout', [AuthenticationController::class, 'logout']);
    
    Route::post('/verify-email', [EmailController::class, 'send_verification']);
    Route::post('/email-verification/{id}/{hash}', [EmailController::class, 'verify_email']);
});

// Login Signp Routes
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);


// Password Reset Routes
Route::post('/reset-request', [PasswordController::class, 'reset_request']);
Route::post('/password-reset', [PasswordController::class, 'reset_password']);