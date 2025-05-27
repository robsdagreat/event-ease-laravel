<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FirebaseAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            Log::warning('FirebaseAuth: No token provided.');
            return response()->json(['error' => 'Unauthorized. No token provided.'], 401);
        }

        try {
            $firebase = (new Factory)
                ->withServiceAccount(storage_path('firebase-credentials.json'))
                ->createAuth();

            Log::info('FirebaseAuth: Firebase Auth Factory created.');

            $verifiedToken = $firebase->verifyIdToken($token);
            $firebaseUid = $verifiedToken->claims()->get('sub');
            
            // Find or create user
            $user = User::where('firebase_uid', $firebaseUid)->first();
            
            if (!$user) {
                // Create new user if doesn't exist
                Log::info('FirebaseAuth: Creating new user with Firebase UID: ' . $firebaseUid);
                $user = User::create([
                    'firebase_uid' => $firebaseUid,
                    'email' => $verifiedToken->claims()->get('email'),
                    'name' => $verifiedToken->claims()->get('name') ?? explode('@', $verifiedToken->claims()->get('email'))[0],
                ]);
                Log::info('FirebaseAuth: User created successfully: ' . $user->id);
            } else {
                // Log existing user found
                Log::info('FirebaseAuth: Found existing user with Firebase UID: ' . $firebaseUid);
            }

            // Set the authenticated user for the current request
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

            // auth()->guard('api')->login($user); // Remove or comment out this line
            Log::info('FirebaseAuth: User authenticated successfully for this request: ' . $user->id);

            $request->attributes->set('firebase_user', $user);

            return $next($request);
        } catch (FailedToVerifyToken $e) {
            Log::error('Firebase Token Verification Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Authentication failed. Invalid token.', 'details' => $e->getMessage()], 401);
        } catch (\Throwable $e) {
            Log::error('Firebase Middleware Internal Error: ' . $e->getMessage());
            return response()->json(['error' => 'Authentication failed. An internal error occurred.', 'details' => $e->getMessage()], 500);
        }
    }
} 