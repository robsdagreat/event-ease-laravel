<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\EventTypeController;

// Public routes (no authentication needed)
Route::get('venues', [VenueController::class, 'index']);
Route::get('venues/{venue}', [VenueController::class, 'show']);
Route::get('event-types', [EventTypeController::class, 'index']);
Route::get('event-types/{eventType}', [EventTypeController::class, 'show']);
Route::get('events', [EventController::class, 'index']);
Route::get('events/{event}', [EventController::class, 'show']);
Route::get('specials', [SpecialController::class, 'index']);
Route::get('specials/{special}', [SpecialController::class, 'show']);

// Protected routes (require Firebase authentication)
Route::middleware('auth.firebase')->group(function () {
    Route::post('events', [EventController::class, 'store']);
    Route::get('venue-bookings', [VenueBookingController::class, 'index']);
    Route::post('venue-bookings', [VenueBookingController::class, 'store']);
    Route::get('venue-bookings/{venueBooking}', [VenueBookingController::class, 'show']);
});

// Admin routes (require Firebase auth AND admin role)
Route::middleware(['auth.firebase', 'admin'])->prefix('admin')->group(function () {
    // Venues
    Route::get('venues', [Admin\VenueController::class, 'index']);
    Route::post('venues', [Admin\VenueController::class, 'store']);
    Route::get('venues/{venue}', [Admin\VenueController::class, 'show']);
    Route::put('venues/{venue}', [Admin\VenueController::class, 'update']);
    Route::delete('venues/{venue}', [Admin\VenueController::class, 'destroy']);
    
    // Events
    Route::get('events', [Admin\EventController::class, 'index']);
    Route::get('events/{event}', [Admin\EventController::class, 'show']);
    Route::put('events/{event}', [Admin\EventController::class, 'update']);
    Route::patch('events/{event}/toggle-approval', [Admin\EventController::class, 'toggleApproval']);
    Route::delete('events/{event}', [Admin\EventController::class, 'destroy']);
    
    // Specials
    Route::get('specials', [Admin\SpecialController::class, 'index']);
    Route::post('specials', [Admin\SpecialController::class, 'store']);
    Route::get('specials/{special}', [Admin\SpecialController::class, 'show']);
    Route::put('specials/{special}', [Admin\SpecialController::class, 'update']);
    Route::patch('specials/{special}/toggle-active', [Admin\SpecialController::class, 'toggleActive']);
    Route::delete('specials/{special}', [Admin\SpecialController::class, 'destroy']);
    
    // Users
    Route::get('users', [Admin\UserController::class, 'index']);
    Route::get('users/{user}', [Admin\UserController::class, 'show']);
    Route::put('users/{user}', [Admin\UserController::class, 'update']);
    Route::patch('users/{user}/toggle-admin', [Admin\UserController::class, 'toggleAdmin']);
    
    // Dashboard statistics
    Route::get('dashboard', [Admin\DashboardController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
