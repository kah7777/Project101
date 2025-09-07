<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildMoodEvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'exercise_id' => $this->exercise_id,
            'duration' => $this->duration,

            'mood' => $this->mood,
            'mood_label' => $this->getMoodLabelAttribute(),

            'participation' => $this->participation,
            'participation_label' => $this->getParticipationLabelAttribute(),

            'activity_completion' => $this->activity_completion,
            'activity_completion_label' => $this->getActivityCompletionLabelAttribute(),
            'exercise' => new ExerciseResource($this->whenLoaded('exercise')),

            'created_at' => $this->created_at->format('Y-m-d H:i:s')

        ];
    }
}
