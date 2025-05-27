<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\SpecialController;

Route::apiResource('events', EventController::class);
Route::apiResource('venues', VenueController::class);
Route::apiResource('specials', SpecialController::class);

Route::get('venues/suggest', [VenueController::class, 'suggest']);
Route::get('specials/venue/{venueId}', [SpecialController::class, 'byVenue']);
Route::get('specials/type/{type}', [SpecialController::class, 'byType']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\SpecialController;

// Specials endpoints
Route::get('specials/active', [SpecialController::class, 'active']);
Route::get('specials/upcoming', [SpecialController::class, 'upcoming']);
Route::get('specials/search', [SpecialController::class, 'search']);
Route::get('venues/search', [VenueController::class, 'search']);
Route::get('events/upcoming', [EventController::class, 'upcoming']);
Route::get('events/search', [EventController::class, 'search']);
Route::get('specials/establishment-type/{type}', [SpecialController::class, 'byEstablishmentType']);
Route::get('specials/location/{location}', [SpecialController::class, 'byLocation']);
Route::get('specials/venue/{venueId}', [SpecialController::class, 'byVenue']);
Route::get('specials/type/{type}', [SpecialController::class, 'byType']);
Route::get('events/venue/{venueId}', [EventController::class, 'byVenue']);
Route::get('events/type/{type}', [EventController::class, 'byType']);
Route::get('events/status/{status}', [SpecialController::class, 'byStatus']); // Corrected controller
Route::get('venues/type/{type}', [VenueController::class, 'byType']);
Route::get('venues/location/{location}', [VenueController::class, 'byLocation']);
Route::get('venues/available', [VenueController::class, 'available']);
Route::get('venues/suggest', [VenueController::class, 'suggest']);
Route::get('events/user/{userId}', [EventController::class, 'getEventsByUser']);

// Public Auth routes (these might typically be protected, but following instruction)
Route::get('auth/user', [AuthController::class, 'user']);
Route::post('auth/logout', [AuthController::class, 'logout']);


// Protected route (Firebase authentication required)
Route::post('events', [EventController::class, 'store'])->middleware('firebase.auth');

// Note: Routes like events/user/{firebaseUserId} and venues/user/{firebaseUserId} still exist
// but are now public. If they should be protected, they would need the middleware applied individually.

// Admin routes, protected by the system.account middleware
Route::middleware('system.account')->group(function () {
    Route::post('admin/events', [EventController::class, 'store']);
    Route::post('admin/venues', [VenueController::class, 'store']);
    Route::post('admin/specials', [SpecialController::class, 'store']);
});

// System/Admin login endpoint
Route::post('system/login', [AuthController::class, 'login']);