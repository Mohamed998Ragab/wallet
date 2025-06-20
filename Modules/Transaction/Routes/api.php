<?php


use Modules\Transaction\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/transactions', [TransactionController::class, 'index']);
});