<?php


use Modules\WithdrawRequest\Controllers\WithdrawRequestController;

use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/withdrawals', [WithdrawRequestController::class, 'index'])
            ->name('admin.withdrawals.index')
            ->middleware('admin.permission:accept_withdrawals');
            
        Route::get('/withdrawals/create', [WithdrawRequestController::class, 'create'])
            ->name('admin.withdrawals.create');
            
        Route::post('/withdrawals', [WithdrawRequestController::class, 'store'])
            ->name('admin.withdrawals.store');
            
        Route::post('/withdrawals/{id}/approve', [WithdrawRequestController::class, 'approve'])
            ->name('admin.withdrawals.approve')
            ->middleware('admin.permission:accept_withdrawals');
            
        Route::post('/withdrawals/{id}/reject', [WithdrawRequestController::class, 'reject'])
            ->name('admin.withdrawals.reject')
            ->middleware('admin.permission:accept_withdrawals');
    });
});
