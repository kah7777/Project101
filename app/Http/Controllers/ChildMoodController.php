<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreChildMoodRequest;
use App\Http\Resources\ChildMoodEvaluationResource;
use App\Http\Resources\ChildResource;
use App\Models\ChildMoodEvaluation;
use App\Services\ApiResponseService;

class ChildMoodController extends Controller
{
    public function store(StoreChildMoodRequest $request)
    {
        try {
            $child = auth()->user()->child()->first();

            if (!$child) {
                return ApiResponseService::error('No child associated with this user', 404);
            }

            $evaluation = ChildMoodEvaluation::create([
                'child_id' => $child->id,
                'mood' => $request->mood,
                'participation' => $request->participation,
                'activity_completion' => $request->activity_completion
            ]);

            return ApiResponseService::success([
                'evaluation' => ChildMoodEvaluationResource::make($evaluation),
                'child' => ChildResource::make($child)
            ], 'Mood evaluation created successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to create mood evaluation: ' . $e->getMessage(),
                500
            );
        }
    }
}
