<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Models\Special;
use App\Models\VenueBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics.
     */
    public function index()
    {
        // Get counts
        $userCount = User::count();
        $venueCount = Venue::count();
        $eventCount = Event::count();
        $pendingEventCount = Event::where('is_approved', false)->count();
        $specialCount = Special::count();
        $bookingCount = VenueBooking::count();
        
        // Get events by month
        $eventsByMonth = Event::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('YEAR(date) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('date', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Get venues by type
        $venuesByType = Venue::select('venue_type', DB::raw('COUNT(*) as count'))
            ->groupBy('venue_type')
            ->get();
            
        // Get top venues
        $topVenues = Venue::withCount('events')
            ->orderBy('events_count', 'desc')
            ->limit(5)
            ->get();
            
        // Get recent events
        $recentEvents = Event::with(['user', 'venue'])
            ->latest()
            ->limit(5)
            ->get();
            
        return response()->json([
            'counts' => [
                'users' => $userCount,
                'venues' => $venueCount,
                'events' => $eventCount,
                'pending_events' => $pendingEventCount,
                'specials' => $specialCount,
                'bookings' => $bookingCount,
            ],
            'charts' => [
                'events_by_month' => $eventsByMonth,
                'venues_by_type' => $venuesByType,
            ],
            'top_venues' => $topVenues,
            'recent_events' => $recentEvents,
        ]);
    }
}