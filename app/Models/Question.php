<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);

    }

    public function doesBelongToTest(Test $test): bool
    {
        return $this->test_id==$test->id;
    }

}
