<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseInformation;
use App\Models\CourseMaterialInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;

class CourseInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = CourseInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('course_information.index', compact('courses', 'classifications', 'details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'company_id' => 'required|numeric',
            'Course_classification_id' => 'required|numeric',
            'coursename' => 'required|string|max:255',
            'coursename_kana' => 'nullable|string|max:255',
            'course_description' => 'required|string',
            'possible_retake_course_deadline' => 'nullable|date',
            'remarks' => 'nullable|string',
            'todo_type' => 'nullable|string|max:255',
            'todo_description' => 'nullable|string',
            'repeated_retest' => 'nullable|string|max:255',
            'test_passed_score' => 'nullable|numeric',
            'course_attributes_01' => 'nullable|string|max:255',
            'course_attributes_02' => 'nullable|string|max:255',
            'course_attributes_03' => 'nullable|string|max:255',
            'course_attributes_04' => 'nullable|string|max:255',
            'course_attributes_05' => 'nullable|string|max:255',
        ]);

        // Simpan data ke dalam database menggunakan model CourseInformation
        CourseInformation::create([
            'company_id' => $request->input('company_id'),
            'Course_classification_id' => $request->input('Course_classification_id'),
            'course_classification_details_id' => $request->input('course_classification_details_id'),
            'coursename' => $request->input('coursename'),
            'coursename_kana' => $request->input('coursename_kana'),
            'course_description' => $request->input('course_description'),
            'possible_retake_course_deadline' => $request->input('possible_retake_course_deadline'),
            'remarks' => $request->input('remarks'),
            'todo_type' => $request->input('todo_type'),
            'todo_description' => $request->input('todo_description'),
            'repeated_retest' => $request->input('repeated_retest'),
            'test_passed_score' => $request->input('test_passed_score'),
            'course_attributes_01' => $request->input('course_attributes_01'),
            'course_attributes_02' => $request->input('course_attributes_02'),
            'course_attributes_03' => $request->input('course_attributes_03'),
            'course_attributes_04' => $request->input('course_attributes_04'),
            'course_attributes_05' => $request->input('course_attributes_05'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = CourseInformation::find($id);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Temukan data kursus yang akan diubah
        $course = CourseInformation::findOrFail($id);

        // Validasi data yang diterima dari formulir
        $request->validate([
            'company_id' => 'required|numeric',
            'Course_classification_id' => 'required|numeric',
            'coursename' => 'required|string|max:255',
            'coursename_kana' => 'nullable|string|max:255',
            'course_description' => 'required|string',
            'possible_retake_course_deadline' => 'nullable|date',
            'remarks' => 'nullable|string',
            'todo_type' => 'nullable|string|max:255',
            'todo_description' => 'nullable|string',
            'repeated_retest' => 'nullable|string|max:255',
            'test_passed_score' => 'nullable|numeric',
            'course_attributes_01' => 'nullable|string|max:255',
            'course_attributes_02' => 'nullable|string|max:255',
            'course_attributes_03' => 'nullable|string|max:255',
            'course_attributes_04' => 'nullable|string|max:255',
            'course_attributes_05' => 'nullable|string|max:255',
        ]);

        // Update data kursus dengan data baru dari formulir
        $course->update([
            'company_id' => $request->input('company_id'),
            'Course_classification_id' => $request->input('Course_classification_id'),
            'course_classification_details_id' => $request->input('course_classification_details_id'),
            'coursename' => $request->input('coursename'),
            'coursename_kana' => $request->input('coursename_kana'),
            'course_description' => $request->input('course_description'),
            'possible_retake_course_deadline' => $request->input('possible_retake_course_deadline'),
            'remarks' => $request->input('remarks'),
            'todo_type' => $request->input('todo_type'),
            'todo_description' => $request->input('todo_description'),
            'repeated_retest' => $request->input('repeated_retest'),
            'test_passed_score' => $request->input('test_passed_score'),
            'course_attributes_01' => $request->input('course_attributes_01'),
            'course_attributes_02' => $request->input('course_attributes_02'),
            'course_attributes_03' => $request->input('course_attributes_03'),
            'course_attributes_04' => $request->input('course_attributes_04'),
            'course_attributes_05' => $request->input('course_attributes_05'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseInformation::destroy($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }

    /**
     * Show the Course Registration page.
     */
    public function courseRegistration()
    {
        return view('course-registration');
    }
}
