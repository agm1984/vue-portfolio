<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Example;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->all());

        $categories = Category::query()->get();

        \Log::debug($categories);

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function show(Request $request, Category $category)
    {
        \Log::debug($request->all());

        return response()->json([
            'category' => $category->load(['examples.category', 'examples.images']),
        ]);
    }

}
