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
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

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

        return response()->json([
            'example' => $example,
        ], 201);
    }

    public function edit(Request $request, Example $example)
    {
        // optional policy check if you use them
        // $this->authorize('update', $example);

        $data = $request->validate([
            // scalars — all optional for PATCH
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'name'        => ['sometimes', 'string', 'max:255'],
            'slug'        => ['sometimes', 'string', 'max:255', Rule::unique('examples', 'slug')->ignore($example->id)],
            'summary'     => ['sometimes', 'string', 'max:2000'],
            'conclusion'  => ['sometimes', 'string', 'max:2000'],
            'status'      => ['sometimes', 'integer', Rule::in([Example::STATUS_INACTIVE, Example::STATUS_ACTIVE])],

            // links array (optional)
            'links'           => ['sometimes', 'array'],
            'links.*.id'      => ['sometimes', 'integer', 'exists:links,id'],
            'links.*.name'    => ['required_with:links', 'string', 'max:255'],
            'links.*.url'     => ['required_with:links', 'url', 'max:2048'],
            'links.*._delete' => ['sometimes', 'boolean'],

            // tags array (optional) — strings or {id: ...}
            'tags'   => ['sometimes', 'array'],
            'tags.*' => ['nullable'],

            // remove old images
            'images_to_remove'   => ['sometimes', 'array'],
            'images_to_remove.*' => ['integer', 'exists:example_images,' . (new ExampleImage)->getKeyName()],

            // add new images
            'images'   => ['sometimes', 'array'],
            'images.*' => ['file', 'image', 'max:5120'], // 5MB each
        ]);

        $updated = DB::transaction(function () use ($request, $example, $data) {
            // 1) Update simple fields
            $example->fill(Arr::only($data, [
                'status', 'category_id', 'name', 'slug', 'summary', 'conclusion',
            ]));

            if ($example->isDirty()) {
                $example->save();
            }

            // 2) Links — upsert/delete when provided
            if ($request->has('links')) {
                foreach ($request->input('links', []) as $link) {
                    // delete
                    if (!empty($link['_delete'])) {
                        if (!empty($link['id'])) {
                            $example->links()->whereKey($link['id'])->delete();
                        }
                        continue;
                    }

                    // update-or-create
                    if (!empty($link['id'])) {
                        $example->links()->updateOrCreate(
                            ['id' => $link['id']],
                            ['name' => $link['name'] ?? '', 'url' => $link['url'] ?? '']
                        );
                    } else {
                        Link::generate($example->id, $link['name'] ?? '', $link['url'] ?? '');
                    }
                }
            }

            // 3) Tags — sync when provided (strings or objects with id)
            if ($request->has('tags')) {
                $tagIds = collect($request->input('tags', []))
                    ->map(function ($tag) {
                        if (is_array($tag) && isset($tag['id'])) {
                            return (int) $tag['id'];
                        }
                        if (is_string($tag) && $tag !== '') {
                            return Tag::firstOrCreate(['name' => $tag])->id;
                        }
                        return null;
                    })
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                $example->tags()->sync($tagIds);
            }

            // 4) OLD images: delete when requested
            $ids = collect(Arr::wrap($request->input('images_to_remove', [])))
                ->map(static fn ($v) => is_scalar($v) ? (int) $v : 0)
                ->filter()
                ->unique()
                ->values();

            if ($ids->isNotEmpty()) {
                $pk = (new ExampleImage)->getKeyName();

                $images = $example->images()
                    ->whereIn($pk, $ids->all())
                    ->get([$pk, 'filename']);

                if ($images->isNotEmpty()) {
                    $paths = $images->map(fn ($img) => "examples/{$example->slug}/{$img->filename}")->all();

                    Storage::disk('public')->delete($paths);
                    $example->images()->whereIn($pk, $images->pluck($pk)->all())->delete();
                }
            }

            // 5) NEW image uploads
            $files = $request->file('images', []);
            if (!empty($files)) {
                foreach ($files as $file) {
                    // build a collision-safe filename, preserve extension
                    $orig = $file->getClientOriginalName();
                    $ext  = $file->getClientOriginalExtension();
                    $base = $ext
                        ? Str::slug(pathinfo($orig, PATHINFO_FILENAME))
                        : Str::slug($orig);
                    $base = $base ?: 'image';

                    $dir = "examples/{$example->slug}";
                    $name = $base . '.' . ($ext ?: $file->guessExtension() ?: 'bin');

                    // ensure uniqueness under public disk
                    $candidate = $name;
                    $i = 1;
                    while (Storage::disk('public')->exists("{$dir}/{$candidate}")) {
                        $candidate = "{$base}-{$i}." . ($ext ?: $file->guessExtension() ?: 'bin');
                        $i++;
                    }

                    $file->storeAs($dir, $candidate, 'public');

                    $example->images()->create([
                        'filename' => $candidate,
                        'status' => ExampleImage::STATUS_ACTIVE,
                    ]);
                }
            }

            return $example->fresh(['category', 'images', 'links', 'tags']);
        });

        return response()->json([
            'example' => $updated,
        ], 200);
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
