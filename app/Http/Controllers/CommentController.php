<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function like(Comment $comment)
    {
        try {
            $user = Auth::user();

            if ($comment->likes()->where('user_id', $user->id)->exists()) {
                return ApiResponseService::error('Already liked', 400);
            }

            $comment->likes()->create(['user_id' => $user->id]);

            return ApiResponseService::success(null, 'Comment liked successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to like comment: ' . $e->getMessage(), 500);
        }
    }

    public function unlike(Comment $comment)
    {
        try {
            $user = Auth::user();

            $like = $comment->likes()->where('user_id', $user->id)->first();
            if (!$like) {
                return ApiResponseService::error('You have not liked this comment', 400);
            }

            $like->delete();
            return ApiResponseService::success(null, 'Comment unliked successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to unlike comment: ' . $e->getMessage(), 500);
        }
    }

    public function store(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content'   => 'required|string',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            $comment = $post->comments()->create([
                'user_id'   => $request->user()->id,
                'content'   => $request->content,
                'parent_id' => $request->parent_id ?? null,
            ]);

            $comment->load('user', 'likes', 'replies');

            return ApiResponseService::success(new CommentResource($comment), 'Comment added successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to add comment: ' . $e->getMessage(), 500);
        }
    }


    public function destroy(Comment $comment)
    {
        try {
            $user = Auth::user();

            if ($comment->user_id !== $user->id) {
                return ApiResponseService::error('You are not allowed to delete this comment', 403);
            }

            $comment->likes()->delete();
            $comment->delete();

            return ApiResponseService::success(null, 'Comment deleted successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to delete comment: ' . $e->getMessage(), 500);
        }
    }
}
