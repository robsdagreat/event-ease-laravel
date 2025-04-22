<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Special;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    /**
     * Display a listing of all specials.
     */
    public function index(Request $request)
    {
        $query = Special::query();
        
        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->active == 'true');
        }
        
        return response()->json($query->latest()->get());
    }

    /**
     * Store a newly created special.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'discount' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image_url' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'discounted_price' => 'required|numeric|min:0|lt:original_price',
            'valid_until' => 'nullable|date|after:today',
            'is_active' => 'sometimes|boolean',
            'description' => 'nullable|string',
        ]);

        $special = Special::create($validated);
        return response()->json($special, 201);
    }

    /**
     * Display the specified special.
     */
    public function show(Special $special)
    {
        return response()->json($special);
    }

    /**
     * Update the specified special.
     */
    public function update(Request $request, Special $special)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'discount' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'image_url' => 'sometimes|string',
            'original_price' => 'sometimes|numeric|min:0',
            'discounted_price' => 'sometimes|numeric|min:0',
            'valid_until' => 'sometimes|nullable|date',
            'is_active' => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string',
        ]);

        $special->update($validated);
        return response()->json($special);
    }

    /**
     * Toggle active status of a special.
     */
    public function toggleActive(Special $special)
    {
        $special->is_active = !$special->is_active;
        $special->save();
        
        return response()->json([
            'message' => $special->is_active ? 'Special activated' : 'Special deactivated',
            'is_active' => $special->is_active
        ]);
    }

    /**
     * Remove the specified special.
     */
    public function destroy(Special $special)
    {
        $special->delete();
        return response()->json(['message' => 'Special deleted successfully']);
    }
}