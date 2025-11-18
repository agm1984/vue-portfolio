<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Models\Example;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    public function create(Request $request, Example $example)
    {
        \Log::debug($request->all());

        $user = Auth::user();
        \Log::debug($user);

        $comment = Comment::generate(
            $user->id,
            $example->id,
            $request->input('body'),
        );

        return response()->json($comment, 200);
    }

    public function edit(Request $request, Comment $comment)
    {
        \Log::debug($request->all());

        $comment->body = $request->input('body');
        $comment->save();

        $comments = Comment::query()->get();

        return response()->json([
            'success' => true,
        ]);
    }

    public function delete(Request $request, Comment $comment)
    {
        \Log::debug($request->all());

        $comment->delete();

        return response()->json([
            'success' => true,
        ]);
    }

}
