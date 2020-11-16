<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TagController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->all());

        $categories = Tag::query()->get();

        \Log::debug($categories);

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function getAll()
    {
        // \Log::debug($request->all());
        $tags = Tag::query()->get();

        return response()->json([
            'tags' => $tags,
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
