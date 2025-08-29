<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\LearningResource;
use App\Models\Learning;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function myLearnings(Request $request)
    {
        try {
            $user = $request->user();

            $learnings = Learning::where('user_id', $user->id)
                ->latest()
                ->get();

            return ApiResponseService::success([
                'learnings' => LearningResource::collection($learnings)
            ], 'Learnings retrieved successfully for the authenticated user');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve user learnings: ' . $e->getMessage(), 500);
        }
    }
    public function byCategory($category)
    {
        try {
            $allowedCategories = ['visual', 'auditory', 'verbal', 'sensory'];

            if (!in_array($category, $allowedCategories)) {
                return ApiResponseService::error('Invalid category provided', 400);
            }

            $user = auth()->user();

            $learnings = Learning::where('user_id', $user->id)
                ->where('category', $category)
                ->latest()
                ->get();

            return ApiResponseService::success([
                'learnings' => LearningResource::collection($learnings)
            ], "Learnings retrieved successfully for category: $category");
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve learnings: ' . $e->getMessage(), 500);
        }
    }


    public function showLearning(Request $request, $id)
    {
        try {
            $user = $request->user();

            $learning = Learning::where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();

            return ApiResponseService::success([
                'learning' => new LearningResource($learning)
            ], 'Learning retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve learning: ' . $e->getMessage(), 500);
        }
    }
}
