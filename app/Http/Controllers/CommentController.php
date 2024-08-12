<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'text'=>'required',
            'post_id'=>'required|exists:posts,id',
        ]);
        $comment = Comment::create($data);
        return CommentResource::make($comment);
    }

    public function update(Comment $comment)
    {
        {
            $data = request()->validate([
                'text'=>'required',
                ]);
            $comment->update($data);
            return CommentResource::make($comment);
        }
    }

    public function destroy(Comment $comment)
    {
        return $comment->delete();
    }
}



