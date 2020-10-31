<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Example extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $guarded = [];

    /**
     * Update parent model(s) when this model is updated.
     *
     * @var array
     */
    protected $touches = ['category'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->belongsToMany(ExampleImage::class);
    }

    public static function generate(
        int $category_id,
        string $name,
        string $slug,
        array $images,
        ?array $attributes = []
    ) : self
    {
        $example = self::query()->firstOrNew([ 'slug' => $slug ]);

        $example->fill([
            'status' => self::STATUS_ACTIVE,
            'name' => $name,
        ]);

        foreach ($attributes as $key => $attribute) {
            $example->{$key} = $attribute;
        }

        foreach ($images as $image) {
            \Log::debug('file a');
            \Log::debug($image);

            Storage::putFileAs(
                'examples' .'/'. $slug,
                $image,
                $image->getClientOriginalName()
            );
        }

        $category = Category::findOrFail($category_id);
        $example->category()->associate($category);

        $example->save();

        return $example;
    }

}
