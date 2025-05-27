<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Special;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SpecialController extends Controller
{
    public function index()
    {
        return Special::where('is_active', true)
            ->orderBy('discount_percentage', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'establishment_name' => 'required|string|max:255',
            'establishment_type' => 'required|string|in:restaurant,hotel,cafe,bar,other',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|in:couple,weekend,valentine,holiday,other',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'terms' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'website' => 'nullable|url',
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
            'establishment_name' => 'string|max:255',
            'establishment_type' => 'string|in:restaurant,hotel,cafe,bar,other',
            'location' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'type' => 'in:couple,weekend,valentine,holiday,other',
            'discount_percentage' => 'numeric|min:0|max:100',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'terms' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        $special->update($validated);
        \Log::info('Validated data:', $validated);
        return $special->fresh();
    }

    public function destroy(Special $special)
    {
        $special->delete();
        return response()->noContent();
    }

    /**
     * Get all active specials.
     *
     * @return \Illuminate\Http\Response
     */
    public function active()
    {
        $now = Carbon::now();
        return Special::where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('discount_percentage', 'desc')
            ->get();
    }

    /**
     * Get upcoming specials.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        $now = Carbon::now();
        return Special::where('is_active', true)
            ->where('start_date', '>', $now)
            ->orderBy('start_date', 'asc')
            ->get();
    }

    /**
     * Get specials by establishment type.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function byEstablishmentType($type)
    {
        return Special::where('establishment_type', $type)
            ->where('is_active', true)
            ->orderBy('discount_percentage', 'desc')
            ->get();
    }

    /**
     * Get specials by location.
     *
     * @param  string  $location
     * @return \Illuminate\Http\Response
     */
    public function byLocation($location)
    {
        return Special::where('location', 'like', '%' . $location . '%')
            ->where('is_active', true)
            ->orderBy('discount_percentage', 'desc')
            ->get();
    }

    /**
     * Search specials by various criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = Special::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('establishment_name')) {
            $query->where('establishment_name', 'like', '%' . $request->establishment_name . '%');
        }

        if ($request->has('establishment_type')) {
            $query->where('establishment_type', $request->establishment_type);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('min_discount')) {
            $query->where('discount_percentage', '>=', $request->min_discount);
        }

        if ($request->has('max_discount')) {
            $query->where('discount_percentage', '<=', $request->max_discount);
        }

        if ($request->has('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        return $query->orderBy('discount_percentage', 'desc')->get();
    }

    /**
     * Get featured specials.
     *
     * @return \Illuminate\Http\Response
     */
    public function featured()
    {
        $now = Carbon::now();
        return Special::where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('discount_percentage', 'desc')
            ->limit(5)
            ->get();
    }
}