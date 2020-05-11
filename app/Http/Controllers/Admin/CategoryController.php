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

        $examples = QueryBuilder::for(Example::class)
                ->allowedFilters('category.slug')
                ->get();

        return response()->json($examples->load('category'));
    }

    public function show(Request $request, Example $example)
    {
        \Log::debug($request->all());

        return response()->json($example);
    }

}
