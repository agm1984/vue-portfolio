<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExampleImage extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Update parent model(s) when this model is updated.
     *
     * @var array
     */
    protected $touches = ['example'];

    public function example() {
        return $this->belongsTo(Example::class);
    }

}
