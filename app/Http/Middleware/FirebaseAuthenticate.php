<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class FirebaseAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get token from the Authorization header
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized: No token provided'], 401);
        }

        try {
            // Get Firebase public keys to verify the token
            // This would typically be cached to avoid making a request on every API call
            $publicKeys = $this->getFirebasePublicKeys();
            
            // Decode the JWT header to get the key ID (kid)
            $tokenHeaders = $this->getTokenHeaders($token);
            $kid = $tokenHeaders->kid ?? null;
            
            if (!$kid || !isset($publicKeys[$kid])) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }

            // Verify and decode the token
            $decodedToken = JWT::decode($token, new Key($publicKeys[$kid], 'RS256'));
            
            // Check if the token is from your Firebase project
            // Replace 'your-firebase-project-id' with your actual Firebase project ID
            if (!isset($decodedToken->aud) || $decodedToken->aud !== 'eventease-43d23') {
                return response()->json(['error' => 'Unauthorized: Invalid audience'], 401);
            }

            // Get user from the database or create one if not exists
            $user = $this->getUserFromFirebaseToken($decodedToken);
            
            // Log the user in
            Auth::login($user);
            
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized: ' . $e->getMessage()], 401);
        }
    }

    /**
     * Get Firebase public keys
     */
    private function getFirebasePublicKeys()
    {
        $response = file_get_contents('https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com');
        return json_decode($response, true);
    }

    /**
     * Get token headers
     */
    private function getTokenHeaders($token)
    {
        $tokenParts = explode('.', $token);
        if (count($tokenParts) !== 3) {
            throw new \Exception('Invalid JWT token format');
        }
        
        $headers = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[0]));
        return json_decode($headers);
    }

    /**
     * Find or create a user based on Firebase token
     */
    private function getUserFromFirebaseToken($decodedToken)
    {
        // Get Firebase UID
        $firebaseUid = $decodedToken->sub;
        
        // Find user by Firebase UID
        $user = User::where('firebase_uid', $firebaseUid)->first();
        
        // If user doesn't exist, create one
        if (!$user) {
            $user = User::create([
                'name' => $decodedToken->name ?? 'User',
                'email' => $decodedToken->email ?? "{$firebaseUid}@example.com",
                'password' => bcrypt(str_random(16)), // Random password, won't be used
                'firebase_uid' => $firebaseUid,
            ]);
        }
        
        return $user;
    }
}