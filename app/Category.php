<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['examples_count'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function examples()
    {
        return $this->hasMany(Example::class);
    }

    public function getExamplesCountAttribute()
    {
        return $this->examples->count();
    }
}
