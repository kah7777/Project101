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
}
