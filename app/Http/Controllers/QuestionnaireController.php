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
        // Validasi input form
        $validatedData = $request->validate([
            'questionText' => 'required',
            'answerType' => 'required',
            'isRequired' => 'required',
            // Sesuaikan validasi dengan kebutuhan Anda
        ]);

        // Simpan data ke database
        $question = new Questionnaire();
        $question->question_text = $request->questionText;
        $question->answer_type = $request->answerType;
        $question->is_required = $request->isRequired;
        // Simpan data tambahan sesuai dengan jenis jawaban (text, radio, checkbox, select)
        // Sesuaikan dengan struktur database Anda

        $question->save();

        // Redirect atau response sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Question saved successfully!');
    }
}
