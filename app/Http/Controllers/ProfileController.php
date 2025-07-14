<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateChildRequest;
use App\Http\Resources\ChildResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Services\ProfileService;
use App\Models\Child;

class ProfileController extends Controller
{
    protected $profileservice;

    public function __construct(ProfileService $profileservice)
    {
        $this->profileservice = $profileservice;
    }

    public function updateChildProfile(UpdateChildRequest $request)
    {
        try {
            $updatedData = $this->profileservice->updateChildProfile($request->validated());

            if (!$updatedData) {
                return ApiResponseService::error('Child profile not found', 404);
            }

            return ApiResponseService::success([
                'user' => UserResource::make($updatedData['user']),
                'child' => ChildResource::make($updatedData['child'])
            ], 'Child profile updated successfully');

        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to update child profile: ' . $e->getMessage(),
                500
            );
        }
    }
}