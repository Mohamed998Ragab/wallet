<?php


use Modules\TopUpRequest\Controllers\Api\TopUpRequestController;

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/top-up-requests', [TopUpRequestController::class, 'index']);
    Route::post('/top-up', [TopUpRequestController::class, 'store']);

});