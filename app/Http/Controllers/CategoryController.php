<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $examples = Category::query()->get();

        return response()->json($examples);
    }
}
