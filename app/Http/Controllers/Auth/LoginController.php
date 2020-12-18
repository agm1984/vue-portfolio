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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Send the user's details upon successful authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return void
     */
    public function authenticated(Request $request, User $user)
    {
        return response()->json([
            'user' => $user,
        ]);
    }

}
