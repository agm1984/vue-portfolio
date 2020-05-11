<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->all());

        $users = QueryBuilder::for(User::class)
                ->allowedFilters('category.slug')
                ->get();

        return response()->json($users);
    }

    public function show(Request $request, User $user)
    {
        \Log::debug($request->all());

        return response()->json($user);
    }

}
