<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUpUserIfNotExist(Request $request)
    {
        $checkEmailIfExist = User::checkEmailIfExist($request);
        if(!$checkEmailIfExist){
            $data = User::validateData($request);
            User::Create($data);
        }else {
            return $request->json(422,'Email is already in use');
        }
    }

    public function logInToUser(Request $request)
    {
        $user = User::where("email",$request->email)->first();
        if($user != null && Hash::check($request->password,$user->password)){
           return $user->createToken("device name")->plainTextToken;
        }

    }

    public function logOutFromUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return "logout happened";
    }
}
