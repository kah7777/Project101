<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'content'     => $this->content,
            'user'        => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'likes_count' => $this->likes()->count(),
            'comments_count' => $this->comments()->count(),
            'comments'    => CommentResource::collection($this->whenLoaded('comments')),
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}
