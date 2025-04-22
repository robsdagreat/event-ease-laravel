<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of all venues.
     */
    public function index()
    {
        $venues = Venue::withCount('events')->get();
        return response()->json($venues);
    }

    /**
     * Store a newly created venue.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image_url' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'venue_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
        ]);

        $venue = Venue::create($validated);
        return response()->json($venue, 201);
    }

    /**
     * Display the specified venue.
     */
    public function show(Venue $venue)
    {
        return response()->json($venue->load('events'));
    }

    /**
     * Update the specified venue.
     */
    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'image_url' => 'sometimes|string',
            'capacity' => 'sometimes|integer|min:1',
            'venue_type' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'amenities' => 'sometimes|nullable|array',
        ]);

        $venue->update($validated);
        return response()->json($venue);
    }

    /**
     * Remove the specified venue.
     */
    public function destroy(Venue $venue)
    {
        // Check if venue has associated events
        $eventsCount = $venue->events()->count();
        if ($eventsCount > 0) {
            return response()->json([
                'message' => 'Cannot delete venue with associated events',
                'events_count' => $eventsCount
            ], 422);
        }
        
        $venue->delete();
        return response()->json(['message' => 'Venue deleted successfully']);
    }
}