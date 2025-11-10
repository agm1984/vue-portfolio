<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Example;
use App\Models\ExampleImage;
use App\Models\Link;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', 'unique:examples,slug'],
            'summary'     => ['required', 'string', 'max:2000'],
            'conclusion'  => ['required', 'string', 'max:2000'],

            'links'         => ['sometimes', 'array'],
            'links.*.name'  => ['required_with:links', 'string', 'max:255'],
            'links.*.url'   => ['required_with:links', 'url', 'max:2048'],

            'tags'          => ['sometimes', 'array'],
            'tags.*'        => ['nullable'], // string or {id: ...}

            'images'        => ['sometimes', 'array'],
            'images.*'      => ['file', 'image', 'max:5120'], // KB -> 5MB
        ]);

        $example = DB::transaction(function () use ($request, $data) {
            // Create the Example (pass FILES, not input strings)
            $example = Example::generate(
                $data['category_id'],
                $data['name'],
                $data['slug'],
                $data['summary'],
                $data['conclusion'],
                $request->file('images', [])
            );

            // Links
            foreach ($request->input('links', []) as $link) {
                Link::generate(
                    $example->id,
                    $link['name'] ?? '',
                    $link['url']  ?? ''
                );
            }

            // Tags (support strings or objects with id)
            $tagIds = collect($request->input('tags', []))
                ->map(function ($tag) {
                    if (is_array($tag) && isset($tag['id'])) {
                        return (int) $tag['id'];
                    }
                    if (is_string($tag) && $tag !== '') {
                        return Tag::firstOrCreate(['name' => $tag])->id; // or Tag::generate($tag)->id
                    }
                    return null;
                })
                ->filter()
                ->unique()
                ->values()
                ->all();

            $example->tags()->sync($tagIds);

            return $example->fresh(['category', 'images', 'links', 'tags']);
        });

        return response()->json(['example' => $example], 201);
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

    public function appendImages(Request $request, Example $example)
    {
        \Log::debug('append images');
        \Log::debug($request->all());
        \Log::debug($request->input('images'));

        foreach ($request->input('images') as $image) {
            $image->storeAs(
                'examples' .'/'. $example->slug,
                $image->getClientOriginalName(),
                'public'
            );

            ExampleImage::generate($example->id, $image->getClientOriginalName());
        }

        return response()->json([
            'example' => $example,
        ]);
    }

    public function removeImage(Request $request, Example $example, ExampleImage $exampleImage)
    {
        \Log::debug('remove image');
        \Log::debug($example->slug);
        \Log::debug($exampleImage->filename);

        Storage::disk('public')->delete('/examples/'.$example->slug.'/'.$exampleImage->filename);
        ExampleImage::destroy($exampleImage->id);

        return response()->json([
            'example' => $example,
        ]);
    }

}
