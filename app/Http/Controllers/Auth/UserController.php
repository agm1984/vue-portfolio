<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function editProfile(Request $request)
    {
        \Log::debug($request->input('name'));
        \Log::debug($request->input('email'));
        $user = $request->user();
        $editableFields = ['name', 'email'];

        foreach ($editableFields as $field) {
            if ($request->filled($field)) {
                $user->{$field} = $request->input($field);
            }
        }

        $user->save();

        return response()->json([
            'user' => $user,
        ]);
    }

    public function editPassword(Request $request)
    {
        return response()->json([
            'test' => 'ok',
        ]);
    }
}
