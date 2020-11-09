<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExampleImage extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $guarded = [];

    /**
     * Update parent model(s) when this model is updated.
     *
     * @var array
     */
    protected $touches = ['example'];

    public function getRouteKeyName()
    {
        return 'filename';
    }

    public function example() {
        return $this->belongsTo(Example::class);
    }

    public static function generate(
        int $example_id,
        string $filename,
        ?array $attributes = []
    ) : self
    {
        $image = self::query()->firstOrNew([ 'example_id' => $example_id, 'filename' => $filename ]);

        $image->fill([
            'status' => self::STATUS_ACTIVE,
        ]);

        foreach ($attributes as $key => $attribute) {
            $image->{$key} = $attribute;
        }

        $image->save();

        return $image;
    }

}
