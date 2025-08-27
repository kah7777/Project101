<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        try {
            $exercises = Exercise::latest()->get();

            return ApiResponseService::success([
                'exercises' => ExerciseResource::collection($exercises)
            ], 'Exercises retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve exercises: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $exercise = Exercise::findOrFail($id);

            return ApiResponseService::success([
                'exercise' => ExerciseResource::make($exercise)
            ], 'Exercise retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve exercise: ' . $e->getMessage(), 500);
        }
    }

    public function myExercises(Request $request)
{
    try {
        $user = $request->user();

        $exercises = Exercise::where('user_id', $user->id)
            ->latest()
            ->get();

        return ApiResponseService::success([
            'exercises' => ExerciseResource::collection($exercises)
        ], 'Exercises retrieved successfully for the authenticated user');
    } catch (\Exception $e) {
        return ApiResponseService::error('Failed to retrieve user exercises: ' . $e->getMessage(), 500);
    }
}

    public function byCategory($category)
    {
        try {
            $exercises = Exercise::where('category', $category)->latest()->get();

            return ApiResponseService::success([
                'exercises' => ExerciseResource::collection($exercises)
            ], "Exercises retrieved successfully for category: $category");
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to retrieve exercises: ' . $e->getMessage(), 500);
        }
    }
    public function store(StoreExerciseRequest $request)
    {
        try {
            $user = $request->user();

            $exercise = Exercise::create([
                'name'        => $request->name,
                'duration'    => $request->duration,
                'description' => $request->description,
                'steps'       => $request->steps,
                'category'    => $request->category,
                'user_id'     => $user->id,
            ]);

            if ($request->hasFile('video')) {
                $exercise->addMediaFromRequest('video')->toMediaCollection('exercises');
            }

            return ApiResponseService::success([
                'exercise' => ExerciseResource::make($exercise)
            ], 'Exercise created successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to create exercise: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = auth()->user();
            $exercise = Exercise::findOrFail($id);

            if ($exercise->user_id !== $user->id) {
                return ApiResponseService::error('Unauthorized: You can only delete your own exercises', 403);
            }

            $exercise->clearMediaCollection('exercises');
            $exercise->delete();

            return ApiResponseService::success([], 'Exercise and its video deleted successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error('Failed to delete exercise: ' . $e->getMessage(), 500);
        }
    }
}
