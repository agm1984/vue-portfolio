<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function examples()
    {
        return $this->hasMany(Example::class)->public();
    }

}
