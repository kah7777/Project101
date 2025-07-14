<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

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

    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            $checkEmailIfExist = User::where('email', $data['email'])->exists();

            if ($checkEmailIfExist) {
                return null;
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'gender' => $data['gender'],
            ]);

            if ($data['user_type'] == 'doctor') {
                $this->createDoctor($user, $data);
            } else {
                $this->createChild($user, $data);
            }

            return [
                'user' => $user,
                'token' => $user->createToken('api')->plainTextToken,
            ];
        });
    }
    protected function createDoctor(User $user, array $data)
    {
        $user->doctor()->create([
            'years_of_experience' => $data['years_of_experience'] ?? 1,
            'phone' => $data['phone'] ?? null,
        ]);
    }

    protected function createChild(User $user, array $data)
    {
        $user->child()->create([
            'age' => $data['age'],
            'height' => $data['height'] ?? 0,
            'weight' => $data['weight'] ?? 0,
        ]);
    }


    public function logoutFromUser($request)
    {
        $user = $request->user();

        if (!$user || !($user->currentAccessToken())) {
            return false;
        } else {
            $request->user()->currentAccessToken()->delete();
            return true;
        }
    }
}