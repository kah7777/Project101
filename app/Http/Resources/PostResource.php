<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'text'=>$this->text,
            'created_at'=>$this->created_at->toISO8601String(),
            'post_image_url'=>$this->image->getFullUrl()
        ];
    }

//     id
//             $table->string('title');
// text
}
