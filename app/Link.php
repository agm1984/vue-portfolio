<?php

namespace App;

use App\Example;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_nice'];

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
        string $name,
        string $url,
        ?array $attributes = []
    ) : self
    {
        $link = self::query()->firstOrNew([ 'name' => $name, 'url' => $url ]);

        $link->fill([
            'status' => self::STATUS_ACTIVE,
        ]);

        foreach ($attributes as $key => $attribute) {
            $link->{$key} = $attribute;
        }

        $link->save();

        return $link;
    }

}
