<?php

namespace App;

use App\Example;
use App\Traits\TimestampAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    use TimestampAttributes;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status_nice',
        'created_at_nice',
        'created_at_diff',
        'updated_at_nice',
        'updated_at_diff',
    ];

    public function example() {
        return $this->belongsTo(Example::class);
    }

    public function getStatusNiceAttribute()
    {
        if ($this->status === 0) return 'Inactive';
        if ($this->status === 1) return 'Active';
        throw \Exception('Problem');
    }

    public static function generate(
        int $example_id,
        string $name,
        string $url,
        ?array $attributes = []
    ) : self
    {
        $link = self::query()->firstOrNew([
            'example_id' => $example_id,
            'name' => $name,
            'url' => $url,
        ]);

        $link->fill([
            'status' => self::STATUS_ACTIVE,
        ]);

        foreach ($attributes as $key => $attribute) {
            $link->{$key} = $attribute;
        }

        $link->save();

        return $link;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }

}
