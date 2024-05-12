<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseInformation;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('courselist', compact('classifications', 'details'));
    }

    /**
     * Filter courses based on the given criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        // Retrieve filter criteria from the request
        $classificationId = $request->input('course_classification_id');
        $detailId = $request->input('course_classification_details_id');
        $courseName = $request->input('course_name');

        // Query courses based on the filter criteria
        $courses = CourseInformation::query();

        if ($classificationId) {
            $courses->where('course_classification_id', $classificationId);
        }

        if ($detailId) {
            $courses->where('course_classification_details_id', $detailId);
        }

        if ($courseName) {
            $courses->where('coursename', 'like', '%' . $courseName . '%');
        }

        $filteredCourses = $courses->get();

        // Return filtered courses to the view
        return view('filtered_courses', compact('filteredCourses'));
    }

    public function settings()
    {
        // Lakukan apa yang perlu dilakukan untuk menampilkan halaman course settings
        return view('coursesettings');
    }

}
