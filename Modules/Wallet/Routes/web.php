<?php

use Modules\Wallet\Controllers\AdminWalletController;

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {


    Route::middleware('auth:admin')->group(function () {
        Route::get('/wallet', [AdminWalletController::class, 'show'])->name('admin.wallet.show');
    });
});
