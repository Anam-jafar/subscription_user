<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('subscriptionLogin')->with('warning', 'Anda perlu log masuk untuk mengakses halaman ini.');
        }
        return $next($request);
    }
}
