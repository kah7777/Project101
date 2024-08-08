<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Http\Resources\TestResource;
use App\Models\Answer;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function show(Request $request, Test $test)
    {


        return response()->json(TestResource::make($test));
    }

    public function check(Test $test, Request $request)
    {
        $request->validate([
            'answer_ids'=>'required|array',
            'answer_ids.*'=>'required|integer|exists:answers,id',
        ]);

        $answers = Answer::whereIn('id', $request->answers)->get();

        foreach($answers as $answer) {
            if(!$answer->doesBelongToTest($test)) {
                throw new \Exception('make sure all answers belongs to the Test',422);
            }
        }

        if($answers->sum('grade') >= $test->threshold)  {
            return response()->json([
                'has_passed'=>true,
            ]);
        }
        return response()->json([
            'has_passed'=>false,
        ]);
    }

}

