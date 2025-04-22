<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by admin status
        if ($request->has('admin')) {
            $query->where('is_admin', $request->admin == 'true');
        }
        
        return response()->json($query->withCount(['events'])->latest()->get());
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return response()->json($user->load(['events']));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'is_admin' => 'sometimes|boolean',
        ]);

        $user->update($validated);
        return response()->json($user);
    }

    /**
     * Toggle admin status of a user.
     */
    public function toggleAdmin(User $user)
    {
        // Prevent removing admin status from the last admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return response()->json([
                'message' => 'Cannot remove admin status from the last admin user',
            ], 422);
        }
        
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        return response()->json([
            'message' => $user->is_admin ? 'User promoted to admin' : 'Admin status removed',
            'is_admin' => $user->is_admin
        ]);
    }
}