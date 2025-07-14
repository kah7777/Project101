<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\UserResource;
use App\Services\ApiResponseService;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signUp(SignUpRequest $request)
    {
        try{
            $signUpData = $this->authService->register($request);

            if (!$signUpData) {
                return ApiResponseService::error('Email is already in use', 422);
            }

            return ApiResponseService::success([
                'user' => UserResource::make($signUpData['user']),
                'token' => $signUpData['token']
            ], 'User registered successfully');

        } catch(\Exception $e) {
            return ApiResponseService::error('Sign Up Failed: ' . $e->getMessage(),500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $loginData = $this->authService->loginUser(
                $request->email,
                $request->password
            );

            if (!$loginData) {
                return ApiResponseService::error('Invalid credentials', 401);
            }

            return ApiResponseService::success([
                'user' => UserResource::make($loginData['user']),
                'token' => $loginData['token']
            ], 'Login successfully');

        } catch (\Exception $e) {
            return ApiResponseService::error('Login failed: ' . $e->getMessage(), 500);
        }
    }


       public function logout(Request $request)
    {
        try {
            $logout = $this->authService->logoutFromUser($request);

            if (!$logout) {
                return ApiResponseService::error('Unauthenticated',401);
            }

            return ApiResponseService::success([],'Logout Successfully');
        } catch(\Exception $e) {
            return ApiResponseService::error('Logout failed:' .$e->getMessage(),500);
        }

    }

}
