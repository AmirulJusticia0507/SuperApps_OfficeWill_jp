<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseInformation;
use App\Models\CourseMaterialInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\EmployeeInformation;
use App\Models\CourseScheduleResultsInformation;

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
        $courses = CourseInformation::all();
        $affiliations = AffiliationInformation::all();
        $employees = EmployeeInformation::all();
        $jobTitles = JobInformation::all(); // Initialize the $jobTitles variable
        
        // Pass the $classifications variable to the view
        return view('courselist', compact('classifications', 'details', 'filteredCourses', 'employees', 'filteredEmployees', 'courses', 'affiliations', 'jobTitles'));
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
        $coursesQuery = CourseInformation::query();
    
        if ($classificationId) {
            $coursesQuery->where('course_classification_id', $classificationId);
        }
    
        if ($detailId) {
            $coursesQuery->where('course_classification_details_id', $detailId);
        }
    
        if ($courseName) {
            $coursesQuery->where('coursename', 'like', '%' . $courseName . '%');
        }
    
        // Get the filtered courses
        $filteredCourses = $coursesQuery->get();
    
        // Get classifications data from the model
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $employees = EmployeeInformation::all();
        // Return filtered courses to the view
        return view('coursesettings', compact('filteredCourses', 'classifications','details', 'filteredEmployees','employees'));
    }
    
    public function filterEmployee(Request $request)
    {
        // Ambil nilai input dari permintaan filter
        $affiliationId = $request->input('affiliationId');
        $jobId = $request->input('jobId');
        $fullname = $request->input('fullname');
        $employeeCode = $request->input('employee_code');
        $sex = $request->input('sex');
        $dateOfBirth = $request->input('date_of_birth');
        $dateOfJoining = $request->input('date_of_joining');

        // Query karyawan berdasarkan kriteria filter
        $employeesQuery = EmployeeInformation::query();

        if ($affiliationId) {
            $employeesQuery->where('affiliation_id', $affiliationId);
        }

        if ($jobId) {
            $employeesQuery->where('job_id', $jobId);
        }

        if ($fullname) {
            $employeesQuery->where('fullname', 'like', '%' . $fullname . '%');
        }

        if ($employeeCode) {
            $employeesQuery->where('employee_code', 'like', '%' . $employeeCode . '%');
        }

        if ($sex) {
            $employeesQuery->where('sex', $sex);
        }

        if ($dateOfBirth) {
            $employeesQuery->whereDate('date_of_birth', $dateOfBirth);
        }

        if ($dateOfJoining) {
            $employeesQuery->whereDate('date_of_joining', $dateOfJoining);
        }

        // Dapatkan karyawan yang difilter
        $filteredEmployees = $employeesQuery->get();

        // Dapatkan data afiliasi, jabatan, dan kursus dari model
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $courses = CourseInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();

        // Kembalikan karyawan yang difilter ke tampilan
        return view('coursesettings', compact('filteredEmployees', 'affiliations', 'jobTitles', 'courses', 'classifications', 'details'));
    }

    public function settings()
    {
        // Mendapatkan data klasifikasi dari model
        $classifications = CourseClassificationInformation::all();
    
        // Mendapatkan data detail dari model
        $details = CourseClassificationDetailInformation::all();
        $employees = EmployeeInformation::all();
        // Mendapatkan data afiliasi dari model
        $affiliations = AffiliationInformation::all();
    
        // Mendapatkan data jabatan dari model
        $jobTitles = JobInformation::all();
        
        // Inisialisasi array kosong untuk filteredCourses
        $filteredCourses = CourseInformation::all();
    
        // Inisialisasi array kosong untuk filteredEmployees
        $filteredEmployees = EmployeeInformation::all();
    
        // Kembalikan view dengan data yang diperlukan
        return view('coursesettings', compact('classifications', 'details', 'filteredCourses', 'filteredEmployees', 'affiliations', 'employees','jobTitles'));
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
    
        // Ambil data klasifikasi (classification) untuk ditampilkan dalam tampilan
        $classifications = CourseClassificationInformation::all();
    
        // Kirim data yang ditemukan ke dalam view 'coursesettings' sebagai respons AJAX
        return view('partials.course_table', compact('filteredCourses', 'classifications'))->render();
    }

    public function inquiry()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all(); 
        $employees = EmployeeInformation::all();
        $courses = CourseInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('courseinquiry', compact('affiliations', 'jobTitles', 'employees', 'classifications', 'courses', 'details'));
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

    // CourseController.php
    public function listCoursesTaken()
    {
        $courses = CourseInformation::all();
        $courseScheduleResults = CourseScheduleResultsInformation::with(['courses', 'employee'])->get();
        // Ambil data material
        $materials = CourseMaterialInformation::all();
        // Kirim data ke view
        return view('listcoursetaken', compact('courseScheduleResults', 'courses', 'materials'));
    }
    

    public function showMaterials()
    {
        // Ambil data material dari model
        $materials = CourseMaterialInformation::all(); 
        // Kirim data material ke view
        return view('materials', compact('materials'));
    }
    
}
