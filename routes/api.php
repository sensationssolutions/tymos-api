<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\WebsitePieceController;
use App\Http\Controllers\SitedetailsController;






Route::post('/login', [AuthController::class, 'login']);
Route::get('/services-list', [ServiceController::class, 'publicList']);
Route::get('/testimonials-list', [TestimonialController::class, 'publicList']);
Route::post('/contact-submit', [ContactController::class, 'store']);

Route::get('/sliders-list', [SliderController::class, 'publicList']);
Route::get('/partners-list', [PartnerController::class, 'publicList']);
Route::get('/website-piece/{type}', [WebsitePieceController::class, 'show']);
Route::get('/websitepieces', [WebsitePieceController::class, 'index']); 
Route::get('/sitedetails', [SitedetailsController::class, 'publicView']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('careers', CareerController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('testimonials', TestimonialController::class);
    Route::get('/dashboard-stats', [DashboardController::class, 'stats']);
    Route::apiResource('sliders', SliderController::class);
    Route::apiResource('websitepieces', WebsitePieceController::class)->except(['index', 'show']);
    Route::apiResource('partners', PartnerController::class);
    Route::post('/sitedetails', [SitedetailsController::class, 'store']);

});
