<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'duration'    => $this->duration,
            'description' => $this->description,
            'steps'       => $this->steps,
            'category'    => $this->category,
            'video'       => $this->getFirstMediaUrl('exercises'),
            'user'        => $this->user->only(['name','email']),
        ];
    }
}
