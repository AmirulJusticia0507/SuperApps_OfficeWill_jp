<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questionnaire;

class QuestionnaireController extends Controller
{
    //index
    public function index()
    {
        $questions = Questionnaire::all();
        return view('questionnaire.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'questionText' => ['required', 'string', 'max:255'],
            'answerType' => ['required', 'in:text,radio,checkbox,selectbox'],
            'isRequired' => ['sometimes', 'boolean'],
        ]);

        Questionnaire::create([
            'question_text' => $data['questionText'],
            'answer_type' => $data['answerType'],
            'is_required' => $data['isRequired'] ?? false,
        ]);

        // Redirect atau response sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Question saved successfully!');
    }
}
