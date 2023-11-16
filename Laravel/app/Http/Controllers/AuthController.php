<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


        // Within your AuthController login method
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        // ... authentication logic
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Make sure you're returning the necessary user data and role
            return response()->json([
                'name' => $user->name,
                'role' => $user->role, // Ensure the user model has the 'role' attribute
                // Include any other necessary data
            ], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

}
