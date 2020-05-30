<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
        'api/refresh',
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
        try {
            foreach ($this->except as $excluded_route) {
                if ($request->path() === $excluded_route) {
                    \Log::debug("Skipping $excluded_route from auth check...");
                    return  $next($request);
                }
            }

            \Log::debug('Authenticating... '. $request->url());

            JWTAuth::parseToken()->authenticate();

            return $next($request);
        } catch (TokenExpiredException $e) {
            \Log::debug('token expired');
            try {
                $customClaims = [];
                $refreshedToken = JWTAuth::claims($customClaims)->refresh(JWTAuth::getToken());
            } catch (TokenExpiredException $e) {
                return response()->json([
                    'error' => 'token_expired',
                    'refresh' => false,
                ], 401);
            }

            return response()->json([
                'error' => 'token_expired_and_refreshed',
                'refresh' => [
                    'token' => $refreshedToken,
                ],
            ], 401);
        } catch (TokenInvalidException $e) {
            \Log::debug('token invalid');
            return response()->json([
                'error' => 'token_invalid',
            ], 401);
        } catch (TokenBlacklistedException $e) {
            \Log::debug('token blacklisted');
            return response()->json([
                'error' => 'token_blacklisted',
            ], 401);
        } catch (JWTException $e) {
            \Log::debug('token absent');
            return response()->json([
                'error' => 'token_absent',
            ], 401);

        }

    }
}
