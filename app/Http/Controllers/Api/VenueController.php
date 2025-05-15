<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        return Venue::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'venue_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'rating' => 'numeric|min:0|max:5',
            'amenities' => 'required|array',
            'images' => 'required|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'website' => 'nullable|url',
            'pricing' => 'nullable|array',
            'special_offers' => 'nullable|array',
            'is_available' => 'boolean',
        ]);

        return Venue::create($validated);
    }

    public function show(Venue $venue)
    {
        return $venue;
    }

    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'location' => 'string',
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'postal_code' => 'string',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'venue_type' => 'string',
            'capacity' => 'integer|min:1',
            'rating' => 'numeric|min:0|max:5',
            'amenities' => 'array',
            'images' => 'array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'website' => 'nullable|url',
            'pricing' => 'nullable|array',
            'special_offers' => 'nullable|array',
            'is_available' => 'boolean',
        ]);

        $venue->update($validated);
        return $venue;
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return response()->noContent();
    }

    public function suggest(Request $request)
    {
        $validated = $request->validate([
            'event_type' => 'required|string',
            'expected_attendees' => 'required|integer|min:1',
            'date' => 'required|date',
            'location' => 'nullable|string',
        ]);

        $query = Venue::where('capacity', '>=', $validated['expected_attendees'])
            ->where('venue_type', $validated['event_type'])
            ->where('is_available', true);

        if (isset($validated['location'])) {
            $query->where('location', 'like', '%' . $validated['location'] . '%');
        }

        return $query->orderBy('rating', 'desc')
            ->limit(10)
            ->get();
    }
}