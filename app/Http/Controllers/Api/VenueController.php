<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of venues with optional filtering
     */
    public function index(Request $request)
    {
        $query = Venue::query();
        
        // Filter by capacity if provided
        if ($request->has('capacity') && $request->capacity > 0) {
            $query->where('capacity', '>=', $request->capacity);
        }
        
        // Filter by venue type if provided
        if ($request->has('type') && $request->type !== 'all') {
            $query->where(function($q) use ($request) {
                $q->where('venue_type', $request->type)
                  ->orWhere('venue_type', 'Multi-purpose');
            });
        }
        
        return response()->json($query->get());
    }

    /**
     * Display the specified venue
     */
    public function show(Venue $venue)
    {
        return response()->json($venue);
    }
}