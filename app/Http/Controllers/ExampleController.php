<?php

namespace App\Http\Controllers;

use App\Example;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        $examples = Example::query()->get()->load('category');

        return response()->json($examples);
    }

    public function show(Request $request, Example $example)
    {
        return response()->json($example);
    }

}
