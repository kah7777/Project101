<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function doesBelongToTest(Test $test): bool
    {
        return $this->question->doesBelongToTest($test);
    }
}
