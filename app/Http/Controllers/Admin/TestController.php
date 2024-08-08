<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create()
    {

        $data = request()->validate([
            'title'=>'required|string',
            'threshold'=>'required|decimal:0,10',
            'is_beginner'=>'required|boolean'
        ]);
        Test::create($data);
    }
}
