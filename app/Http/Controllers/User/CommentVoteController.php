<?php

namespace App\Http\Controllers\User;
namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentVoteController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'value' => ['required', 'in:1,-1'],
        ]);

        $userId = $request->user()->id;

        $comment->votes()->updateOrCreate(
            ['user_id' => $userId],
            ['value' => $data['value']]
        );

        return response()->json([
            'score'      => $comment->votes()->sum('value'),
            'upvotes'    => $comment->votes()->where('value', 1)->count(),
            'downvotes'  => $comment->votes()->where('value', -1)->count(),
        ]);
    }

    public function destroy(Request $request, Comment $comment)
    {
        $userId = $request->user()->id;

        $comment->votes()
            ->where('user_id', $userId)
            ->delete();

        return response()->json([
            'score'      => $comment->votes()->sum('value'),
            'upvotes'    => $comment->votes()->where('value', 1)->count(),
            'downvotes'  => $comment->votes()->where('value', -1)->count(),
        ]);
    }
}
