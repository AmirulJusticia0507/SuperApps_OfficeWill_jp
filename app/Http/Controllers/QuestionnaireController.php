<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Models\TestAnswer;
use App\Models\CourseScheduleResultsInformation;
use Illuminate\Support\Facades\Redirect;

class QuestionnaireController extends Controller
{
    // Metode untuk menyimpan pertanyaan baru
    public function storeQuestion(Request $request)
    {
        // Validasi input jika diperlukan
        $validatedData = $request->validate([
            'question_text' => 'required',
            'answer_type' => 'required',
            'is_required' => 'required',
        ]);

        // Simpan pertanyaan ke dalam tabel questionnaire
        Questionnaire::create([
            'question_text' => $request->question_text,
            'answer_type' => $request->answer_type,
            'is_required' => $request->is_required,
        ]);

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Question saved successfully!');
    }

    // Metode untuk menyimpan tanggapan survei baru
    public function storeSurveyResponse(Request $request)
    {
        // Validasi input jika diperlukan
        $validatedData = $request->validate([
            'question_id' => 'required',
            'employee_id' => 'required',
            'response_text' => 'required',
        ]);

        // Simpan tanggapan survei ke dalam tabel questionnaire
        Questionnaire::create([
            'question_id' => $request->question_id,
            'employee_id' => $request->employee_id,
            'response_text' => $request->response_text,
        ]);

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Survey response saved successfully!');
    }

    // Metode untuk menyimpan jawaban dari kuesioner
    public function saveAnswer(Request $request)
    {
        // Validasi input jika diperlukan
        $validatedData = $request->validate([
            'question_id' => 'required',
            'employee_id' => 'required',
            'answered' => 'required',
        ]);

        // Simpan jawaban ke dalam tabel questionnaire
        Questionnaire::create([
            'question_id' => $request->question_id,
            'employee_id' => $request->employee_id,
            'answered' => $request->answered,
        ]);

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Answer saved successfully!');
    }

    // Method untuk menampilkan survei-responses
    public function showSurveyResponses()
    {
        $courseScheduleResults = $this->showCourseScheduleResults();
        // Redirect pengguna ke halaman survei-responses
        return view('survey_responses.index', compact('courseScheduleResults'));
        // return Redirect::route('survey-responses.index');
    }

    public function showTestAnswers()
    {
        // Ambil data jawaban tes dari model
        $testAnswers = TestAnswer::all();

        // Tampilkan view untuk menampilkan jawaban tes
        return view('test_answer.index', compact('testAnswers'));
    }

    public function showReportInputs()
    {
        // Ambil data input laporan dari model
        $reportInputs = Questionnaire::whereNotNull('report_input')->get();

        // Tampilkan view untuk menampilkan input laporan
        return view('reportinputs.index', compact('reportInputs'));
    }

    public function showCourseScheduleResults()
    {
        // Ambil data dari model CourseScheduleResultsInformation
        $courseScheduleResults = CourseScheduleResultsInformation::all();
        
        // Tampilkan view untuk menampilkan data tersebut
        return $courseScheduleResults;
    }
}
