<?php


use Modules\TopUpRequest\Controllers\AdminTopUpRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {


    Route::middleware('auth:admin')->group(function () {


        Route::get('/top-ups', [AdminTopUpRequestController::class, 'index'])->name('admin.topups.index')->middleware('admin.permission:accept_topup');
        Route::post('/top-ups/{id}/approve', [AdminTopUpRequestController::class, 'approve'])->name('admin.topups.approve')->middleware('admin.permission:accept_topup');
        Route::post('/top-ups/{id}/reject', [AdminTopUpRequestController::class, 'reject'])->name('admin.topups.reject')->middleware('admin.permission:accept_topup');
    });
});
