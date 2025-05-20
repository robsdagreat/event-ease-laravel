<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\SpecialController;
use App\Http\Controllers\Api\AuthController;

// Auth routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::options('auth/login', function() { return response()->json('OK', 200, ['Access-Control-Allow-Origin' => 'http://localhost:3000', 'Access-Control-Allow-Headers' => 'Content-Type, Authorization']); });
Route::post('auth/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);

    // Specials endpoints
    Route::get('specials/active', [SpecialController::class, 'active']);
    Route::get('specials/upcoming', [SpecialController::class, 'upcoming']);
    Route::get('specials/search', [SpecialController::class, 'search']);
    Route::get('specials/featured', [SpecialController::class, 'featured']);
    Route::get('specials/establishment-type/{type}', [SpecialController::class, 'byEstablishmentType']);
    Route::get('specials/location/{location}', [SpecialController::class, 'byLocation']);
    Route::get('specials/venue/{venueId}', [SpecialController::class, 'byVenue']);
    Route::get('specials/type/{type}', [SpecialController::class, 'byType']);

    // Event endpoints
    Route::get('events/venue/{venueId}', [EventController::class, 'byVenue']);
    Route::get('events/type/{type}', [EventController::class, 'byType']);
    Route::get('events/status/{status}', [EventController::class, 'byStatus']);
    Route::get('events/upcoming', [EventController::class, 'upcoming']);
    Route::get('events/search', [EventController::class, 'search']);
    Route::get('events/user/{firebaseUserId}', [EventController::class, 'byUser']);

    // Additional venue endpoints
    Route::get('venues/type/{type}', [VenueController::class, 'byType']);
    Route::get('venues/location/{location}', [VenueController::class, 'byLocation']);
    Route::get('venues/search', [VenueController::class, 'search']);
    Route::get('venues/available', [VenueController::class, 'available']);
    Route::get('venues/suggest', [VenueController::class, 'suggest']);
    Route::get('venues/user/{firebaseUserId}', [VenueController::class, 'byUser']);

    // Resource routes
    Route::apiResource('venues', VenueController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('specials', SpecialController::class);
});