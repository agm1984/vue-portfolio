<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ExampleImage;
use App\Models\Tag;
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
        'upvotes',
        'downvotes',
        'user_vote',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function example() {
        return $this->belongsTo(Example::class);
    }

    public function votes()
    {
        return $this->hasMany(CommentVote::class);
    }

    public function getUpvotesAttribute()
    {
        return (int) $this->votes()->where('value', 1)->count();
    }

    public function getDownvotesAttribute()
    {
        return (int) $this->votes()->where('value', -1)->count();
    }

    public function getUserVoteAttribute()
    {
        $userId = auth()->id();

        if (! $userId) {
            return null;
        }

        $vote = $this->relationLoaded('votes')
            ? $this->votes->firstWhere('user_id', $userId)
            : $this->votes()->where('user_id', $userId)->first();

        return $vote ? (int) $vote->value : null;
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
