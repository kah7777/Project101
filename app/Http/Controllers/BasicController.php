<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class BasicController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $basics = collect();


        $basics->put('biggener_test_id',Test::getBeginnerTestId());

        return response()->json($basics);
    }
}
