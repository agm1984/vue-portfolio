<?php

namespace App;

use App\Category;
use App\Example;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tag extends Model
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

    public function examples() {
        return $this->belongsToMany(Example::class);
    }

    public static function generate(
        string $name,
        ?array $attributes = []
    ) : self
    {
        $tag = self::query()->firstOrNew([ 'name' => $name ]);

        $tag->fill([
            'status' => self::STATUS_ACTIVE,
        ]);

        foreach ($attributes as $key => $attribute) {
            $tag->{$key} = $attribute;
        }

        $tag->save();

        return $tag;
    }

}
