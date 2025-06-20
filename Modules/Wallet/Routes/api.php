<?php

use Modules\Wallet\Controllers\Api\WalletController;

use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wallet', [WalletController::class, 'show']);

});