<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Example;
use App\Link;
use App\Tag;
use App\Http\Controllers\Controller;
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
            'examples' => $examples->load('category'),
        ]);
    }

    public function show(Request $request, Example $example)
    {
        return response()->json([
            'example' => $example->load(['category', 'images', 'links', 'tags']),
        ]);
    }

    public function create(Request $request)
    {
        \Log::debug($request->all());
        // \Log::debug($request->headers->all());

        $example = Example::generate(
            $request->input('category_id'),
            $request->input('name'),
            $request->input('slug'),
            $request->input('summary'),
            $request->input('conclusion'),
            $request->input('images'),
        );

        foreach ($request->input('links') as $link) {
            Link::generate(
                $example->id,
                $link['name'],
                $link['url']
            );
        }

        $tags = [];
        foreach ($request->input('tags') as $tag) {
            if (!is_array($tag)) {
                $new_tag = Tag::generate($tag);
                array_push($tags, $new_tag->id);
            } else {
                array_push($tags, $tag['id']);
            }
        }
        $example->tags()->sync($tags);

        return response()->json([
            'example' => $example,
        ]);
    }

    public function edit(Request $request, Example $example)
    {
        \Log::debug('edit success 123');
        \Log::debug($request->all());
        $editableFields = [
            'name',
            'slug',
            'summary',
            'conclusion',
        ];

        foreach ($editableFields as $field) {
            if ($request->filled($field)) {
                $example->{$field} = $request->input($field);
            }
        }

        $example->save();

        $category = Category::findOrFail($request->input('category_id'));
        $example->category()->associate($category);

        $example->links()->delete();
        foreach ($request->input('links') as $link) {
            Link::generate(
                $example->id,
                $link['name'],
                $link['url']
            );
        }

        $tags = [];
        foreach ($request->input('tags') as $tag) {
            if (!is_array($tag)) {
                $new_tag = Tag::generate($tag);
                array_push($tags, $new_tag->id);
            } else {
                array_push($tags, $tag['id']);
            }
        }
        $example->tags()->sync($tags);

        return response()->json([
            'example' => $example,
        ]);
    }

    public function editImages(Request $request, Example $example)
    {
        \Log::debug('edit example images');
        \Log::debug($example);
        \Log::debug($request->all());
        // \Log::debug($request->headers->all());

        return response()->json([
            'example' => $example,
        ]);
    }

    public function editLinks(Request $request, Example $example)
    {
        \Log::debug('edit example links');
        \Log::debug($example);
        \Log::debug($request->all());

        return response()->json([
            'example' => $example,
        ]);
    }

    public function editTags(Request $request, Example $example)
    {
        \Log::debug('edit example tags');
        \Log::debug($example);
        \Log::debug($request->all());

        return response()->json([
            'example' => $example,
        ]);
    }

}
