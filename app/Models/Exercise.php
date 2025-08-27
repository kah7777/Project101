<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Exercise extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

     protected $fillable = [
        'name',
        'duration',
        'description',
        'steps',
        'category',
        'user_id'
    ];

    protected $casts = [
        'steps' => 'array',
        'duration' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
