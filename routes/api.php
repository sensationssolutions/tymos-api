<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\DashboardController;


Route::post('/login', [AuthController::class, 'login']);
Route::get('/services-list', [ServiceController::class, 'publicList']);
Route::get('/testimonials-list', [TestimonialController::class, 'publicList']);
Route::post('/contact-submit', [ContactController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('careers', CareerController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('testimonials', TestimonialController::class);
    Route::get('/dashboard-stats', [DashboardController::class, 'stats']);

});
