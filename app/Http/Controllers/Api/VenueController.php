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
        \Log::info('Destroy method called', ['venue_id' => $venue->id]);
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

    /**
     * Get venues by type.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function byType($type)
    {
        return Venue::where('venue_type', $type)
            ->where('is_available', true)
            ->orderBy('rating', 'desc')
            ->get();
    }

    /**
     * Get venues by location.
     *
     * @param  string  $location
     * @return \Illuminate\Http\Response
     */
    public function byLocation($location)
    {
        return Venue::where('location', 'like', '%' . $location . '%')
            ->orWhere('city', 'like', '%' . $location . '%')
            ->orWhere('state', 'like', '%' . $location . '%')
            ->orWhere('country', 'like', '%' . $location . '%')
            ->where('is_available', true)
            ->orderBy('rating', 'desc')
            ->get();
    }

    /**
     * Search venues by various criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        \Log::info('Search method called', ['request' => $request->all()]);
        $query = Venue::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('venue_type')) {
            $query->where('venue_type', $request->venue_type);
        }

        if ($request->has('location')) {
            $query->where(function($q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%')
                  ->orWhere('city', 'like', '%' . $request->location . '%')
                  ->orWhere('state', 'like', '%' . $request->location . '%')
                  ->orWhere('country', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->has('min_capacity')) {
            $query->where('capacity', '>=', $request->min_capacity);
        }

        if ($request->has('max_capacity')) {
            $query->where('capacity', '<=', $request->max_capacity);
        }

        if ($request->has('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        if ($request->has('amenities')) {
            $amenities = explode(',', $request->amenities);
            $query->where(function ($q) use ($amenities) {
                foreach ($amenities as $amenity) {
                    $q->orWhereJsonContains('amenities', $amenity);
                }
            });
        }

        if ($request->has('is_available')) {
            $query->where('is_available', $request->is_available);
        }

        return $query->orderBy('rating', 'desc')->get();
    }

    /**
     * Get all available venues.
     *
     * @return \Illuminate\Http\Response
     */
    public function available()
    {
        \Log::info('Available method called');
        return Venue::where('is_available', true)
            ->orderBy('rating', 'desc')
            ->get();
    }
}