<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class ArticalController extends Controller
{

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
