<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DiagnosisResource;

class DiagnosisController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'visual'   => 'required|integer',
                'auditory' => 'required|integer',
                'verbal'   => 'required|integer',
                'sensory'  => 'required|integer',
            ]);

            $data['user_id'] = Auth::user()->id;

            $diagnosis = Diagnosis::create($data);

            $scores = [
                'visual'   => $diagnosis->visual,
                'auditory' => $diagnosis->auditory,
                'verbal'   => $diagnosis->verbal,
                'sensory'  => $diagnosis->sensory,
            ];

            $maxValue = max($scores);
            $dominant = array_keys($scores, $maxValue);

            return ApiResponseService::success([
                'diagnosis' => new DiagnosisResource($diagnosis),
                'dominant'  => $dominant,
            ], 'Diagnosis stored successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to store diagnosis: ' . $e->getMessage(),
                500
            );
        }
    }

    public function showLast()
    {
        try {
            $userId = Auth::user()->id;
            $diagnosis = Diagnosis::where('user_id', $userId)->latest()->first();

            if (!$diagnosis) {
                return ApiResponseService::error('No diagnosis found for this user', 404);
            }

            $scores = [
                'visual'   => $diagnosis->visual,
                'auditory' => $diagnosis->auditory,
                'verbal'   => $diagnosis->verbal,
                'sensory'  => $diagnosis->sensory,
            ];

            $maxValue = max($scores);
            $dominant = array_keys($scores, $maxValue);

            return ApiResponseService::success([
                'diagnosis' => new DiagnosisResource($diagnosis),
                'dominant'  => $dominant,
            ], 'Diagnosis retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to retrieve diagnosis: ' . $e->getMessage(),
                500
            );
        }
    }
}
