<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Example;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->all());

        $categories = QueryBuilder::for(Category::class)
                ->allowedFilters('category.slug')
                ->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }
}
