<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of all events.
     */
    public function index(Request $request)
    {
        $query = Event::with(['user', 'venue', 'eventType']);
        
        // Filter by approval status
        if ($request->has('approved')) {
            $query->where('is_approved', $request->approved == 'true');
        }
        
        // Filter by host type
        if ($request->has('host_type')) {
            $query->where('host_type', $request->host_type);
        }
        
        return response()->json($query->latest()->get());
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return response()->json($event->load(['user', 'venue', 'eventType']));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image_url' => 'sometimes|string',
            'date' => 'sometimes|date',
            'capacity' => 'sometimes|integer|min:1',
            'is_approved' => 'sometimes|boolean',
            'host_type' => 'sometimes|in:personal,professional',
            'is_public' => 'sometimes|boolean',
            'host_name' => 'sometimes|nullable|string|max:255',
            'host_contact' => 'sometimes|nullable|string|max:255',
            'host_description' => 'sometimes|nullable|string',
        ]);

        $event->update($validated);
        return response()->json($event);
    }

    /**
     * Toggle approval status of an event.
     */
    public function toggleApproval(Event $event)
    {
        $event->is_approved = !$event->is_approved;
        $event->save();
        
        return response()->json([
            'message' => $event->is_approved ? 'Event approved' : 'Event unapproved',
            'is_approved' => $event->is_approved
        ]);
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}