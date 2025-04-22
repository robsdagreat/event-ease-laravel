<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of events, with optional filtering.
     */
    public function index(Request $request)
    {
        $query = Event::with(['venue', 'eventType']);
        
        // Filter by upcoming events
        if ($request->has('upcoming') && $request->upcoming) {
            $query->where('date', '>=', now());
        }
        
        // Filter by event type
        if ($request->has('type') && $request->type !== 'all') {
            $eventType = EventType::where('name', $request->type)->first();
            if ($eventType) {
                $query->where('event_type_id', $eventType->id);
            }
        }
        
        // Filter by public events
        if ($request->has('public')) {
            $query->where('is_public', true);
        }
        
        // Filter by user's events
        if ($request->has('user') && Auth::check()) {
            $query->where('user_id', Auth::id());
        }
        
        return response()->json($query->orderBy('date')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'event_type_id' => 'required|exists:event_types,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|string',
            'date' => 'required|date|after:today',
            'capacity' => 'required|integer|min:1',
            'host_type' => 'required|in:personal,professional',
            'is_public' => 'boolean',
            'host_name' => 'nullable|required_if:host_type,professional|string|max:255',
            'host_contact' => 'nullable|required_if:host_type,professional|string|max:255',
            'host_description' => 'nullable|required_if:host_type,professional|string',
        ]);
        
        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = false; // Default to not approved
        
        $event = Event::create($validated);
        
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json($event->load(['venue', 'eventType', 'user']));
    }
}