<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Controllers\AuthController;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
});

    // Authenticated admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', fn () => view('admin::admin.dashboard'))->name('admin.dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
