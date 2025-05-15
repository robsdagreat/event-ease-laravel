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