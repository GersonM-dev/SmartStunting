<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // List all users (optional: for admin use)
    public function index()
    {
        // You can add admin check here!
        $users = User::all();
        return response()->json($users);
    }

    // Get currently authenticated user profile
    public function profile()
    {
        return response()->json(Auth::user());
    }

    // Show user detail by id (optional)
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update the authenticated user's profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    // Delete the authenticated user
    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
