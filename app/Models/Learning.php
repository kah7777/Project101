<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'description',
        'steps',
        'category',
        'user_id',
        'vedio',
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

