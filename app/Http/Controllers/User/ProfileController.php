<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return response()->json($user, 200);
    }
}
