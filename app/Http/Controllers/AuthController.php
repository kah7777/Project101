<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
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

    public function logInToUser(Request $request)
    {
        $user = User::where("email",$request->email)->first();
        if($user != null && Hash::check($request->password,$user->password)){
            $token = $user->createToken("api");
            return response()->json([
                'user' => UserResource::make($user),
                'token' => $token->plainTextToken
            ]);
        }
    }

    public function logOutFromUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return "logout happened and token for the login was deleted";
    }
}
