<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Exclude these routes from authentication check.
     *
     * Note: https://laracasts.com/discuss/channels/laravel/middleware-on-all-routes-except-one?page=1#reply=611575
     *
     * @var array
     */
    protected $except = [
        'api/logout',
    ];

    /**
     * Ensure the user is authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // \Log::debug($request->header);
        // \Log::debug($request->session()->all());

        if (Auth::check()) {
            \Log::debug('Authenticate@ is logged in...');
            if (Auth::viaRemember()) {
                \Log::debug('IS VIA REMEMBER');
            }
            return $next($request);
        }

        \Log::debug('Authenticate@ isnt logged in...');
        return response()->json([
            'error' => 'UNAUTHENTICATED',
        ], 401);

    }

}
