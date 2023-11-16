<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsDeliveryPersonnel
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'delivery') {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
