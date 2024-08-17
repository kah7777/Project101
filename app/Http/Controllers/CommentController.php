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
        $data["user_id"] = request()->user()->id;
        $comment = Comment::create($data);
        return CommentResource::make($comment);
    }

    public function update(Post $post ,Comment $comment)
    {
    abort_unless(request()->user()->id == $comment->user_id,403,"UnAuthorized");
            $data = request()->validate([
                'text'=>'required',
                ]);
            $comment->update($data);
            return CommentResource::make($comment);
    }

    public function destroy(Post $post, Comment $comment)
    {
        abort_unless(request()->user()->id == $comment->user_id,403,"UnAuthorized");
        return $comment->delete();
    }
}



