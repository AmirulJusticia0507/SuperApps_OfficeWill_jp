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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    public function index()
    {
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $filteredCourses = CourseInformation::all();
        $filteredEmployees = [];
        $courses = CourseInformation::all();
        $affiliations = AffiliationInformation::all();
        $employees = EmployeeInformation::all();
        $jobTitles = JobInformation::all();
        
        return view('courselist', compact('classifications', 'details', 'filteredCourses', 'employees', 'filteredEmployees', 'courses', 'affiliations', 'jobTitles'));
    }
    
    public function filter(Request $request)
    {
        $classificationId = $request->input('course_classification_id');
        $detailId = $request->input('course_classification_details_id');
        $courseName = $request->input('course_name');
    
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
    
        $filteredCourses = $coursesQuery->get();
    
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $employees = EmployeeInformation::all();
        
        return view('coursesettings', compact('filteredCourses', 'classifications','details', 'filteredEmployees','employees'));
    }
    
    public function filterEmployee(Request $request)
    {
        $affiliationId = $request->input('affiliationId');
        $jobId = $request->input('jobId');
        $fullname = $request->input('fullname');
        $employeeCode = $request->input('employee_code');
        $sex = $request->input('sex');
        $dateOfBirth = $request->input('date_of_birth');
        $dateOfJoining = $request->input('date_of_joining');

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

        $filteredEmployees = $employeesQuery->get();

        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $courses = CourseInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();

        return view('coursesettings', compact('filteredEmployees', 'affiliations', 'jobTitles', 'courses', 'classifications', 'details'));
    }

    public function settings()
    {
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $employees = EmployeeInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $filteredCourses = CourseInformation::all();
        $filteredEmployees = EmployeeInformation::all();
        
        return view('coursesettings', compact('classifications', 'details', 'filteredCourses', 'filteredEmployees', 'affiliations', 'employees','jobTitles'));
    }
    
    public function search(Request $request)
    {
        $classificationId = $request->input('classificationId');
        $detailId = $request->input('detailId');
        $courseName = $request->input('courseName');
    
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
    
        $classifications = CourseClassificationInformation::all();
    
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
        $jobTitles = JobInformation::all();
        $courses = CourseInformation::all();
        $employees = EmployeeInformation::all();
        
        return view('courseinquiry', compact('classifications', 'details', 'jobTitles', 'courses', 'employees'));
    }

    public function listCoursesTaken()
    {
        $courses = CourseInformation::all();
        $courseScheduleResults = CourseScheduleResultsInformation::with(['courses', 'employee'])->get();
        $materials = CourseMaterialInformation::all();
        
        return view('listcoursetaken', compact('courseScheduleResults', 'courses', 'materials'));
    }

    public function showMaterials()
    {
        $materials = CourseMaterialInformation::all(); 
        
        return view('materials', compact('materials'));
    }
    
}

