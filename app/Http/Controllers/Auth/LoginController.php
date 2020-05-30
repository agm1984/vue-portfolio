<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\VerifyEmailException;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use JWTAuth;

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
        $this->middleware('guest')->except(['refresh', 'logout']);
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param array|null $extras
     *
     * @return array
     */
    protected function getCustomClaims(User $user, ?array $extras = []) : array
    {
        $defaults = [
            'exp' => Carbon::now()->addMinutes(config('jwt.ttl'))->timestamp,
            // 'sub' => $user->id,
            // 'role' => $user->role,
            // 'csrf' => Str::random(42),
            // 'iat' => Carbon::now()->timestamp,
            // 'nbf' => Carbon::now()->timestamp, // not before
        ];

        return array_merge($defaults, $extras);
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
        $user = User::firstWhere('email', $request->input('email'));
        $customClaims = [];
        $token = JWTAuth::claims($customClaims)->attempt($this->credentials($request));

        \Log::debug('Login...');
        \Log::debug($token);

        if (!$token) {
            return false;
        }

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return false;
        }

        $this->guard()->setToken($token);

        return true;
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

        $user = $this->guard()->user();
        $token = (string)$this->guard()->getToken();

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
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
        $user = $this->guard()->user();
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            throw VerifyEmailException::forUser($user);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function refresh(Request $request)
    {
        \Log::debug('Refreshing...');
        $refreshedToken = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'token' => $refreshedToken,
        ], 200);
    }

    /**
     * If the user's session is expired, the auth token is already invalidated,
     * so we just return success to the client.
     *
     * This solves the edge case where the user clicks the Logout button as their first
     * interaction in a stale session, and allows a clean redirect to the login page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        if ($user) {
            $this->guard()->logout();
            $this->guard()->invalidate();
        }

        return response()->json(['success' => 'Logged out.'], 200);
    }
}
