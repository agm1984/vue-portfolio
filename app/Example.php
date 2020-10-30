<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

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
        $images,
        ?array $attributes = []
    ) : self
    {
        \Log::debug('shit ass');
        \Log::debug($images);
        \Log::debug(json_decode($images));

        $category = Category::findOrFail($category_id);

        $example = self::query()->firstOrNew([ 'slug' => $slug ]);

        $example->fill([
            'status' => self::STATUS_ACTIVE,
            'name' => $name,
        ]);

        foreach ($attributes as $key => $attribute) {
            $example->{$key} = $attribute;
        }

        $example->category()->associate($category);
        $example->save();

        return $example;
    }

}
