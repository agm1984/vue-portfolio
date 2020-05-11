<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return boolean
     */
    public function handle($request, Closure $next, $guard = null)
    {
        \Log::debug('running IsAdmin middleware');
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        return response()->json(['error' => 'Already authenticated.'], 400);
    }
}
