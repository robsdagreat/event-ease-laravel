<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Special;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    public function index()
    {
        return Special::where('is_active', true)->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'venue_id' => 'required|exists:venues,id',
            'venue_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|in:couple,weekend,valentine,holiday,other',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'terms' => 'nullable|array',
        ]);

        return Special::create($validated);
    }

    public function show(Special $special)
    {
        return $special;
    }

    public function update(Request $request, Special $special)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'venue_id' => 'exists:venues,id',
            'venue_name' => 'string',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'type' => 'in:couple,weekend,valentine,holiday,other',
            'discount_percentage' => 'numeric|min:0|max:100',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'terms' => 'nullable|array',
        ]);

        $special->update($validated);
        return $special;
    }

    public function destroy(Special $special)
    {
        $special->delete();
        return response()->noContent();
    }

    public function byVenue($venueId)
    {
        return Special::where('venue_id', $venueId)
            ->where('is_active', true)
            ->get();
    }

    public function byType($type)
    {
        return Special::where('type', $type)
            ->where('is_active', true)
            ->get();
    }
}