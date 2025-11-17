<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Example;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Return metrics for the admin dashboard.
     */
    public function metrics(Request $request)
    {
        return response()->json([
            'categories_count'      => Category::count(),
            'examples_count'        => Example::count(),
            'users_count'           => User::count(),
            'users_signed_up_today' => User::whereDate('created_at', now()->toDateString())->count(),
        ]);
    }
}
