<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Special;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    /**
     * Display a listing of active specials.
     */
    public function index()
    {
        $specials = Special::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', now()->toDateString());
            })
            ->get();
            
        return response()->json($specials);
    }

    /**
     * Display the specified special.
     */
    public function show(Special $special)
    {
        return response()->json($special);
    }
}