<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        \Log::debug($request->all());
        $user = $request->user();

        if ($request->hasFile('avatar')) {
            \Log::debug('HAS IMAGE');
            $image = $request->file('avatar');
            \Log::debug($image);

            $image->storeAs(
                'users' .'/'. $user->id,
                $image->getClientOriginalName(),
                'public'
            );

            $user->avatar_filename = $image->getClientOriginalName();
        } else {
            \Log::debug('REMOVE IMAGE OR NO IMAGE EXISTS');
            if ($request->file('avatar') === null) {
                \Log::debug('IS NULL');
            }
        }

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
        $user = $request->user();
        $current_password = $user->password;

        if (Hash::check($request->input('old_password'), $current_password)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return response()->json([
                'user' => $user,
            ]);
        }

        return response()->json([
            'errors' => [
                'old_password' => ['Password is incorrect.'],
            ],
            'message' => 'The given data was invalid.',
        ], 422);



    }
}
