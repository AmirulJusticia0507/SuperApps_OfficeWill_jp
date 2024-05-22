<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseInformation;
use App\Models\CompanyInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use Illuminate\Support\Facades\Auth;

class CourseInformationController extends Controller
{
    public function index()
    {
        $companies = CompanyInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('course_information.index', compact('companies', 'classifications', 'details'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'course_classification_id' => 'required|exists:course_classification_information,course_classification_id',
            'course_classification_details_id' => 'required|exists:course_classification_detail_information,course_classification_details_id',
            'coursename' => 'required|string|max:255',
            'course_description' => 'required|string',
            'possible_retake_course_deadline' => 'required|string',
            'todo_type' => 'required|string',
            'todo_description' => 'required|string',
            'repeated_retest' => 'required|string',
        ]);
    
        $data = $request->all();
        $data['company_id'] = $request->input('company_id');

        $data['course_attributes_01'] = $request->input('course_attributes_01', null);
        $data['course_attributes_02'] = $request->input('course_attributes_02', null);
        $data['course_attributes_03'] = $request->input('course_attributes_03', null);
        $data['course_attributes_04'] = $request->input('course_attributes_04', null);
        $data['course_attributes_05'] = $request->input('course_attributes_05', null);
    
        CourseInformation::create($data);
    
        return redirect()->route('course-registration.index')->with('success', 'Course information has been saved successfully.');
    }
    
}
