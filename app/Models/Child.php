<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mood()
    {
        return $this->hasMany(ChildMoodEvaluation::class);
    }
    protected $casts = [
        'age' => 'integer',
        'height' => 'double',
        'weight' => 'double',
    ];


}
