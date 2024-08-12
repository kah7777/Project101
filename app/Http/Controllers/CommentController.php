<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post)
    {
        $data = request()->validate([
            'text'=>'required',
            'post_id'=>'required|exists:posts,id',
        ]);
        $comment = Comment::create($data);
    }

    public function update(Request $request, Comment $comment)
    {

    }

    public function destroy(Comment $comment)
    {

    }
}



