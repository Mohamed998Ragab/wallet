<?php


use Modules\ReferralCode\Controllers\AdminReferralController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/referrals', [AdminReferralController::class, 'index'])
            ->name('admin.referral.index');
        Route::get('/referrals/generate', [AdminReferralController::class, 'generate'])
            ->name('admin.referral.generate');
    });
});