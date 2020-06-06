<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\VerifyEmailException;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Auth::viaRemember();
        $this->middleware('guest')->except(['logout']);
    }

    /**
     * Authenticates the user via email/password.
     *
     * Pre-requisites:
     * - OAuth: https://tools.ietf.org/html/draft-ietf-oauth-browser-based-apps-06
     * - PKCE: https://tools.ietf.org/html/rfc7636
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    // public function login(LoginRequest $request)
    // {
    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'user' => Auth::user(),
    //         ], 200);
    //     }

    //     throw ValidationException::withMessages([
    //         'email' => ['Email or password is incorrect.']
    //     ]);
    // }

    // might be useful?
    // Session::flush()

    // public function logout()
    // {
    //     \Log::debug('Logging out...');
    //     Auth::logout();

    //     $rememberMeCookie = Auth::getRecallerName();

    //     \Log::debug('remember me');
    //     \Log::debug($rememberMeCookie);

    //     // forget this cookie
    //     $cookie = Cookie::forget($rememberMeCookie);

    //     \Log::debug('coookie');
    //     \Log::debug($cookie);

    //     return response()->json([ 'success' => 'You are now logged out.'], 200)->withCookie($cookie);
    // }

    public function logout(Request $request)
    {
        \Log::debug('Logging out...');
        \Log::debug('user');
        \Log::debug(Auth::user());

        Auth::logout();
        return response()->json(['success' => 'LOGGED_OUT'], 200);
    }

    /**
     * Authenticates the user.
     *
     * API design-understanding pre-requisites:
     * - https://hasura.io/blog/best-practices-of-using-jwt-with-graphql/
     * - https://github.com/tymondesigns/jwt-auth/issues/89#issuecomment-94378594
     * - https://stackoverflow.com/questions/38415851/how-to-make-jwt-cookie-authentication-in-laravel
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // TODO: make this field required so the client always supplies true or false
        // $remember = $request->input('remember');
        $remember = true;

        \Log::debug('testttt ' . Auth::validate($request->only('email', 'password')));

        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $user = User::firstWhere('email', $request->input('email'));

            if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                return false;
            }

            \Log::debug('isAuthenticated? '.Auth::check());

            return true;
        }

        return false;
    }

    /**
     * Send the token to Vue after the user authenticates.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        \Log::debug('Auth::check()'.Auth::check());

        return response()->json([
            'user' => Auth::user(),
        ], 200);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        \Log::debug('running login failed crap');
        $user = Auth::user();
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            throw VerifyEmailException::forUser($user);
        }

        \Log::debug('finna throw errors');
        throw ValidationException::withMessages([
            'email' => ['Email or password is incorrect.']
        ]);
    }

}
