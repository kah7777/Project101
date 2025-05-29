<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ApiResponseService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signUpUserIfNotExist(Request $request)
    {
        $checkEmailIfExist = User::checkEmailIfExist($request);
        if(!$checkEmailIfExist){
            $data = $request->validate([
                "name"=>"required|string",
                "email"=>"required|email|",
                "password"=>"required|max:20",
                'user_type'=> ['required', Rule::in(['doctor', 'guardian'])]
            ]);
            $user = User::Create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            if($data['user_type'] == 'doctor') {
                $user->doctor()->create([]);
            } else {
                $user->guardian()->create([]);
            }
            $token = $user->createToken('api');
            return response()->json([
                'user' => UserResource::make($user),
                'token' => $token->plainTextToken
            ]);
        }else {
            return response()->json([422,'Email is already in use']);
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
            ], 'Login successful');

        } catch (\Exception $e) {
            return ApiResponseService::error('Login failed: ' . $e->getMessage(), 500);
        }
    }

    public function logOutFromUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return "logout happened and token for the login was deleted";
    }
}
