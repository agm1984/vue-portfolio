<?php

namespace App;

use App\Category;
use App\ExampleImage;
use App\Tag;
use App\Traits\TimestampAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
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

    public function author()
    {
        return $this->belongsTo(User::class);
    }

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
        int $author_id,
        int $example_id,
        string $body,
        ?array $attributes = []
    ) : self
    {
        $comment = self::query()->firstOrNew([
            'author_id' => $author_id,
            'example_id' => $example_id,
            'body' => $body,
        ]);

        $comment->fill([
            'status' => self::STATUS_ACTIVE,
            'author_id' => $author_id,
            'example_id' => $example_id,
            'body' => $body,
        ]);

        foreach ($attributes as $key => $attribute) {
            $comment->{$key} = $attribute;
        }

        $comment->save();

        return $comment;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }

}
