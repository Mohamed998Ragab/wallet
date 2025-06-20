<?php


use Modules\ReferralCode\Controllers\Api\ReferralController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/referral/generate', [ReferralController::class, 'generate']);

});