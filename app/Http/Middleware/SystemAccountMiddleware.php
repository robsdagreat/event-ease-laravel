<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SystemAccountMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-System-Api-Key');
        if ($apiKey !== env('SYSTEM_API_KEY')) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        return $next($request);
    }
} 