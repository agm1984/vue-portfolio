<?php

namespace App\Traits;

use Carbon\Carbon;

// docs: https://carbon.nesbot.com/docs/

trait TimestampAttributes
{
    // created
    public function getCreatedAtNiceAttribute()
    {
        return Carbon::parse($this->created_at)->isoFormat('llll');
    }

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // upated
    public function getUpdatedAtNiceAttribute()
    {
        return Carbon::parse($this->updated_at)->isoFormat('llll');
    }

    public function getUpdatedAtDiffAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}
