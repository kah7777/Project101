<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;


class ProfileService
{
    public function updateChildProfile(array $validatedData)
    {
        return DB::transaction(function () use ($validatedData) {
            $user = auth()->user();
            $child = $user->child()->firstOrFail();

            $child->fill([
                'age' => $validatedData['age'] ?? $child->age,
                'height' => $validatedData['height'] ?? $child->height,
                'weight' => $validatedData['weight'] ?? $child->weight,
            ])->save();

            $user->fill([
                'name' => $validatedData['name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
            ])->save();

            return [
                'user' => $user->fresh(),
                'child' => $child->fresh()
            ];
        });
    }

    public function updateDoctorProfile(array $validatedData)
    {
        return DB::transaction(function () use ($validatedData) {
            $user = auth()->user();
            $doctor = $user->doctor()->firstOrFail();

            $doctor->fill([
                'years_of_experience' => $validatedData['years_of_experience'] ?? $doctor->years_of_experience,
                'phone' => $validatedData['phone'] ?? $doctor->phone,
            ])->save();

            $user->fill([
                'name' => $validatedData['name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
            ])->save();

            return [
                'user' => $user->fresh(),
                'doctor' => $doctor->fresh()
            ];
        });
    }
}