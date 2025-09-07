<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreChildMoodRequest;
use App\Http\Resources\ChildMoodEvaluationResource;
use App\Http\Resources\ChildResource;
use App\Models\ChildMoodEvaluation;
use App\Services\ApiResponseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
                'exercise_id' => $request->exercise_id,
                'duration' => $request->duration,
                'mood' => $request->mood,
                'participation' => $request->participation,
                'activity_completion' => $request->activity_completion,
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

    public function weeklyMoodStats()
    {
        try {
            $child = auth()->user()->child;

            if (!$child) {
                return ApiResponseService::error('No child associated with this user', 404);
            }
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek   = Carbon::now()->endOfWeek();

            $stats = ChildMoodEvaluation::where('child_id', $child->id)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->selectRaw('mood, COUNT(*) as count')
                ->groupBy('mood')
                ->pluck('count', 'mood');

            $allMoods = ['angry', 'happy', 'unsure', 'anxious', 'sad'];
            $result = [];
            foreach ($allMoods as $mood) {
                $result[$mood] = $stats[$mood] ?? 0;
            }
            return ApiResponseService::success($result, 'Weekly mood stats retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to retrieve weekly stats: ' . $e->getMessage(),
                500
            );
        }
    }

    public function exercisesDurationByCategory()
    {
        try {
            $child = auth()->user()->child;

            if (!$child) {
                return ApiResponseService::error('No child associated with this user', 404);
            }

            $stats = ChildMoodEvaluation::where('child_id', $child->id)
                ->join('exercises', 'child_mood_evaluations.exercise_id', '=', 'exercises.id')
                ->select('exercises.category', DB::raw('SUM(child_mood_evaluations.duration) as total_duration'))
                ->groupBy('exercises.category')
                ->pluck('total_duration', 'exercises.category');

            $categories = ['visual', 'auditory', 'verbal', 'sensory'];
            $result = [];
            foreach ($categories as $cat) {
                $result[$cat] = $stats[$cat] ?? 0;
            }

            return ApiResponseService::success($result, 'Exercise durations by category retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to retrieve stats: ' . $e->getMessage(),
                500
            );
        }
    }
}
