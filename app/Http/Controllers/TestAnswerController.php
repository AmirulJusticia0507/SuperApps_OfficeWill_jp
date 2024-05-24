<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestAnswer;

class TestAnswerController extends Controller
{
    //
    public function index()
    {
        $testAnswers = TestAnswer::all();
        return view('test_answers.index', compact('testAnswers'));
    }
}
