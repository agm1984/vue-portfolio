<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            \Log::debug('starting');
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                \Log::debug('1');
                 return response()->json([
                   'code'   => 101, // means auth error in the api,
                   'response' => null // nothing to show
                 ]);
            }
        } catch (TokenExpiredException $e) {
            $refreshed = JWTAuth::refresh(JWTAuth::getToken());
            $user = JWTAuth::setToken($refreshed)->toUser();
            header('Authorization: Bearer ' . $refreshed);

            // return response()->json([
            //     'error' => 'token_expired',
            // ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'error' => 'token_invalid',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'token_absent',
            ], 401);

        }

        // catch (TokenExpiredException $e) {
        //     // If the token is expired, then it will be refreshed and added to the headers
        //     try {
        //         $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        //         $user = JWTAuth::setToken($refreshed)->toUser();
        //         header('Authorization: bearer ' . $refreshed);
        //     } catch (JWTException $e) {
        //          return response()->json([
        //            'code'   => 103, // means not refreshable
        //            'response' => null // nothing to show
        //          ]);
        //     }
        // } catch (JWTException $e) {
        //     \Log::debug($e);
        //     return response()->json([
        //            'code'   => 101, // means auth error in the api,
        //            'response' => null // nothing to show
        //     ]);
        // }

        // Login the user instance for global usage
        Auth::login($user, false);

        return  $next($request);
    }
}
