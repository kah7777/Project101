<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class ArticalController extends Controller
{

    public function destroy($id)
    {
        try {
            $user = auth()->user();
            $article = Article::findOrFail($id);

            if ($article->user_id !== $user->id) {
                return ApiResponseService::error('Unauthorized: You can only delete your own articles', 403);
            }

            $article->clearMediaCollection('articles');

            $article->delete();

            return ApiResponseService::success([], 'Article and its image deleted successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to delete article: ' . $e->getMessage(),
                500
            );
        }
    }


    public function index()
    {
        try {
            $articles = Article::latest()->get();

            return ApiResponseService::success([
                'articles' => ArticleResource::collection($articles)
            ], 'Articles retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to retrieve articles: ' . $e->getMessage(),
                500
            );
        }
    }

    public function show($id)
    {
        try {
            $article = Article::findOrFail($id);

            return ApiResponseService::success([
                'article' => ArticleResource::make($article)
            ], 'Article retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to retrieve article: ' . $e->getMessage(),
                500
            );
        }
    }
    public function store(StoreArticleRequest $request)
    {
        try {
            $user = $request->user();

            $article = Article::create([
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'user_id' => $user->id,
            ]);

            if ($request->hasFile('image')) {
                $article->addMediaFromRequest('image')->toMediaCollection('articles');
            }

            return ApiResponseService::success([
                'article' => ArticleResource::make($article)
            ], 'Article created successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to create article: ' . $e->getMessage(),
                500
            );
        }
    }
}
