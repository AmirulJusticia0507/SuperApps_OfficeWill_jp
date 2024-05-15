<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\EmployeeInformation;

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
        $filteredCourses = CourseInformation::all();
        $filteredEmployees = [];
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all(); // Initialize the $jobTitles variable
        return view('courselist', compact('classifications', 'details', 'filteredCourses', 'filteredEmployees', 'affiliations', 'jobTitles'));
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
        return view('courselist', compact('filteredCourses'));
    }

    public function settings()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles  = JobInformation::all();
        $classifications = CourseClassificationInformation::all(); // Get classification data from the model
        $details = CourseClassificationDetailInformation::all(); // Get details data from the model
    
        // Inisialisasi array kosong untuk filteredCourses
        $filteredCourses = CourseInformation::all();
    
        // Inisialisasi array kosong untuk filteredEmployees
        $filteredEmployees = EmployeeInformation::all();
    
        // Kembalikan view dengan data yang diperlukan
        return view('coursesettings', compact('classifications', 'details', 'filteredCourses', 'filteredEmployees','affiliations','jobTitles'));
    }
    
    

    public function search(Request $request)
    {
        // Ambil nilai input dari permintaan pencarian
        $classificationId = $request->input('classificationId');
        $detailId = $request->input('detailId');
        $courseName = $request->input('courseName');

        // Lakukan pencarian berdasarkan kriteria yang diberikan
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

        // Ambil hasil pencarian
        $filteredCourses = $courses->get();

        // Kirim data yang ditemukan ke dalam view 'coursesettings' sebagai respons AJAX
        return view('partials.course_table', compact('filteredCourses'))->render();
    }

    public function inquiry()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all(); 
        $employees = EmployeeInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('courseinquiry', compact('affiliations', 'jobTitles', 'employees', 'classifications', 'details'));
    }

    public function showCourseInquiryForm()
    {
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $jobTitles = JobInformation::all(); // Inisialisasi variabel $jobTitles
        $courses = CourseInformation::all();
        $employees = EmployeeInformation::all();
        return view('courseinquiry', compact('classifications', 'details', 'jobTitles', 'courses', 'employees'));
    }
    
}
