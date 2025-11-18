<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Example;
use App\Models\ExampleImage;
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
     * @param \App\Models\Example $example
     * @param \App\Models\ExampleImage $exampleImage
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
        $comments = $example->comments()
            ->with(['author'])
            ->withSum('votes as score', 'value')
            ->orderByDesc('score')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'comments' => $comments,
        ]);
    }

}
