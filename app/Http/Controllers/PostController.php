<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with(['user', 'comments.user', 'likes'])->latest()->get();

            return ApiResponseService::success(PostResource::collection($posts), 'Posts retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve posts: ' . $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['content' => 'required|string']);

            $post = Post::create([
                'user_id' => $request->user()->id,
                'content' => $request->content,
            ]);

            return ApiResponseService::success(new PostResource($post), 'Post created successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to create post: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            $user = Auth::user();

            if ($post->user_id !== $user->id) {
                return ApiResponseService::error('You are not allowed to delete this post', 403);
            }

            $post->likes()->delete();
            $post->comments()->each(function ($comment) {
                $comment->likes()->delete();
                $comment->delete();
            });
            $post->delete();

            return ApiResponseService::success(null, 'Post deleted successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to delete post: ' . $e->getMessage(), 500);
        }
    }

    public function like(Post $post)
    {
        try {
            $user = Auth::user();

            if ($post->likes()->where('user_id', $user->id)->exists()) {
                return ApiResponseService::error('Already liked', 400);
            }

            $post->likes()->create(['user_id' => $user->id]);

            return ApiResponseService::success(null, 'post liked successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to like post: ' . $e->getMessage(), 500);
        }
    }

    public function unlike(Post $post)
    {
        try {
            $user = Auth::user();

            $like = $post->likes()->where('user_id', $user->id)->first();
            if (!$like) {
                return ApiResponseService::error('You have not liked this post', 400);
            }

            $like->delete();
            return ApiResponseService::success(null, 'post unliked successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to unlike post: ' . $e->getMessage(), 500);
        }
    }
}
