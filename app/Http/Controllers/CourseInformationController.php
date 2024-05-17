<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CompanyInformation;

class CourseInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = CompanyInformation::all();
        $courses = CourseInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('course_information.index', compact('courses', 'classifications', 'details','companies'));
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
        CourseInformation::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('course-registration.index')->with('success', 'Course created successfully');
    }
}
