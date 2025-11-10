<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Example;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->all());

        $categories = Category::query()->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function getAll(Request $request)
    {
        $categories = Category::query()->get();

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

    public function edit(Request $request, Category $category)
    {
        \Log::debug($request->all());

        // OPTIONAL: if you use policies
        // $this->authorize('update', $category);

        $data = $request->validate([
            'status' => ['sometimes', 'integer', Rule::in([Category::STATUS_INACTIVE, Category::STATUS_ACTIVE])],
            'slug'   => ['sometimes', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'name'   => ['sometimes', 'string', 'max:255'],
        ]);

        $category->fill($data)->save();

        return response()->json([
            'category' => $category->fresh(['examples.category', 'examples.images']),
        ]);
    }

}
