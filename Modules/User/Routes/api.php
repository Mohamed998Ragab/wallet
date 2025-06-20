<?php

use Modules\User\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/wallet', [WalletController::class, 'show']);
//     Route::post('/top-up', [TopUpRequestController::class, 'store']);
//     Route::post('/referral/generate', [ReferralController::class, 'generate']);
//     Route::get('/transactions', [TransactionController::class, 'index']);
// });