<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateChildRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\ChildResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Services\ProfileService;
use App\Models\Child;
use Illuminate\Support\Facades\Hash;

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
    public function updateDoctorProfile(UpdateDoctorRequest $request)
    {
        try {
            $updatedData = $this->profileservice->updateDoctorProfile($request->validated());

            if (!$updatedData) {
                return ApiResponseService::error('Doctor profile not found', 404);
            }

            return ApiResponseService::success([
                'user' => UserResource::make($updatedData['user']),
                'doctor' => DoctorResource::make($updatedData['doctor'])
            ], 'Doctor profile updated successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to update doctor profile: ' . $e->getMessage(),
                500
            );
        }
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $user = $request->user();

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return ApiResponseService::success([
                'user' => UserResource::make($user)
            ], 'Password changed successfully');
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to change password: ' . $e->getMessage(),
                500
            );
        }
    }
}
