<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function loginUser(string $email, string $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return [
            'user' => $user,
            'token' => $user->createToken('api')->plainTextToken
        ];
    }

    public function signUpUserIfNotExist(string $name , string $email , string $password ,string $user_type )
    {
        $checkEmailIfExist = User::checkEmailIfExist($email);

        if(!$checkEmailIfExist) {
            $user = User::Create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            if($user_type == 'doctor') {
                $user->doctor()->create([]);
            } else {
                $user->guardian()->create([]);
            }

            return [
                'user' => $user,
                'token' => $user->createToken('api')->plainTextToken,
            ];
        }else {
            return null;
        }
    }

    public function logoutFromUser($request) {
        $user = $request->user();

        if(!$user || !($user->currentAccessToken())) {
            return false;

        }else {
            $request->user()->currentAccessToken()->delete();
            return true;
        }
    }
}
