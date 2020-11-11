<?php

namespace App;

use App\Category;
use App\ExampleImage;
use App\Tag;
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_nice'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(ExampleImage::class);
    }

    public function links() {
        return $this->hasMany(Link::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function getStatusNiceAttribute()
    {
        if ($this->status === 0) return 'Inactive';
        if ($this->status === 1) return 'Active';
        throw \Exception('Problem');
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

        $category = Category::findOrFail($category_id);
        $example->category()->associate($category);
        $example->save();

        foreach ($images as $image) {
            $image->storeAs(
                'examples' .'/'. $slug,
                $image->getClientOriginalName(),
                'public'
            );

            ExampleImage::generate($example->id, $image->getClientOriginalName());
        }

        return $example;
    }

}
