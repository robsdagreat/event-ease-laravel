<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event::with('venue')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type' => 'required|string',
            'venue_id' => 'required|exists:venues,id',
            'venue_name' => 'required|string',
            'firebase_user_id' => 'required|string',
            'organizer_name' => 'required|string',
            'is_public' => 'boolean',
            'expected_attendees' => 'required|integer|min:1',
            'image_url' => 'nullable|url',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'ticket_price' => 'required|numeric|min:0',
            'tags' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
        ]);

        return Event::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return $event->load('venue');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'start_time' => 'date',
            'end_time' => 'date|after:start_time',
            'event_type' => 'string',
            'venue_id' => 'exists:venues,id',
            'venue_name' => 'string',
            'firebase_user_id' => 'string',
            'organizer_name' => 'string',
            'is_public' => 'boolean',
            'expected_attendees' => 'integer|min:1',
            'image_url' => 'nullable|url',
            'status' => 'in:upcoming,ongoing,completed,cancelled',
            'ticket_price' => 'numeric|min:0',
            'tags' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
        ]);

        // Map firebase_user_id to user_id if present
        if (isset($validated['firebase_user_id'])) {
            $validated['user_id'] = $validated['firebase_user_id'];
            unset($validated['firebase_user_id']);
        }

        $event->update($validated);
        return $event->load('venue');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->noContent();
    }

    /**
     * Get events by venue ID.
     *
     * @param  int  $venueId
     * @return \Illuminate\Http\Response
     */
    public function byVenue($venueId)
    {
        return Event::where('venue_id', $venueId)
            ->with('venue')
            ->get();
    }

    /**
     * Get events by type.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function byType($type)
    {
        return Event::where('event_type', $type)
            ->with('venue')
            ->get();
    }

    /**
     * Get events by status.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function byStatus($status)
    {
        return Event::where('status', $status)
            ->with('venue')
            ->get();
    }

    /**
     * Get upcoming events.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        return Event::where('start_time', '>', now())
            ->where('status', 'upcoming')
            ->orderBy('start_time', 'asc')
            ->with('venue')
            ->get();
    }

    /**
     * Search events by various criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = Event::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->has('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('end_time', '<=', $request->end_date);
        }

        if ($request->has('min_price')) {
            $query->where('ticket_price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('ticket_price', '<=', $request->max_price);
        }

        if ($request->has('is_public')) {
            $query->where('is_public', $request->is_public);
        }

        if ($request->has('tags')) {
            $tags = explode(',', $request->tags);
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        return $query->with('venue')->get();
    }
}
