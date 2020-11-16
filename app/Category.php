<?php

namespace App;

use App\Traits\TimestampAttributes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use TimestampAttributes;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

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
        'examples_count',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function examples()
    {
        return $this->hasMany(Example::class);
    }

    public function getStatusNiceAttribute()
    {
        if ($this->status === 0) return 'Inactive';
        if ($this->status === 1) return 'Active';
        throw \Exception('Problem');
    }

    public function getExamplesCountAttribute()
    {
        return $this->examples->count();
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }
}
