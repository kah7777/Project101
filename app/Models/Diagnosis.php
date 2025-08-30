<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visual',
        'auditory',
        'verbal',
        'sensory'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
