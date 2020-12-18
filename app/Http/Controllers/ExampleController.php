<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Example;
use App\ExampleImage;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ExampleController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($request->all());

        $examples = QueryBuilder::for(Example::class)
                ->allowedFilters('category.slug')
                ->get();

        return response()->json([
            'examples' => $examples->load(['category', 'images']),
        ]);
    }

    public function show(Request $request, Example $example)
    {
        return response()->json([
            'example' => $example->load(['category', 'images', 'links', 'tags']),
        ]);
    }

    /**
     * Retrieves one ExampleImage and generates its URL for the client.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Example $example
     * @param \App\ExampleImage $exampleImage
     *
     * @return void
     */
    public function image(Request $request, Example $example, ExampleImage $exampleImage)
    {
        return response()->json([
            'image' => $exampleImage,
            'image_url' => "/storage/examples/{$example->slug}/{$exampleImage->filename}",
        ]);
    }

    public function listComments(Example $example)
    {
        $comments = Comment::query()->where('example_id', $example->id)->get();

        return response()->json([
            'comments' => $comments->load('author'),
        ]);
    }

}
