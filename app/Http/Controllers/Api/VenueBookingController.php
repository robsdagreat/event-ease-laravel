<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VenueBooking;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueBookingController extends Controller
{
    /**
     * Display a listing of the user's venue bookings.
     */
    public function index()
    {
        $bookings = VenueBooking::where('user_id', Auth::id())
            ->with('venue')
            ->orderBy('start_time')
            ->get();
        
        return response()->json($bookings);
    }

    /**
     * Store a newly created venue booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'expected_guests' => 'required|integer|min:1',
            'purpose' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'special_requests' => 'nullable|string',
        ]);
        
        // Check if venue capacity can accommodate the expected guests
        $venue = Venue::findOrFail($request->venue_id);
        if ($request->expected_guests > $venue->capacity) {
            return response()->json([
                'message' => 'Expected guests exceed venue capacity of ' . $venue->capacity,
                'errors' => ['expected_guests' => ['The number of guests exceeds venue capacity']]
            ], 422);
        }
        
        // Check if venue is available for the requested time
        $conflictingBookings = VenueBooking::where('venue_id', $request->venue_id)
            ->where('is_approved', true)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                          ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->count();
            
        if ($conflictingBookings > 0) {
            return response()->json([
                'message' => 'Venue is not available for the selected time',
                'errors' => ['start_time' => ['Venue already booked during this time']]
            ], 422);
        }
        
        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = false; // Default to not approved
        
        $booking = VenueBooking::create($validated);
        
        return response()->json($booking->load('venue'), 201);
    }

    /**
     * Display the specified booking.
     */
    public function show(VenueBooking $venueBooking)
    {
        // Check if booking belongs to current user
        if ($venueBooking->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json($venueBooking->load('venue'));
    }
}