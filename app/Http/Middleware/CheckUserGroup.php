<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserGroup
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and their user_group is "User"
        if (Auth::check() && Auth::user()->user_group === 'USER') {
            return $next($request);
        }

        // Redirect back with error message if access is denied
        return redirect()->back()->with('error', 'Access denied. You are not authorized to view this page.');
    }
}

