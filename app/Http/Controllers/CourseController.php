<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseInformation;
use App\Models\AffiliationInformation;
use App\Models\AttendanceTodoAnswerSelectionInformation;
use App\Models\AttendanceTodoItemAnswerInformation;
use App\Models\CourseScheduleResultsInformation;
use App\Models\EmployeeAttributeSettingInformation;
use App\Models\JobInformation;
use App\Models\EmployeeInformation;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

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
		$courses = CourseInformation::all();
		$filteredEmployees = [];
		$affiliations = AffiliationInformation::all();
		$employees = EmployeeInformation::all();
		$jobTitles = JobInformation::all(); // Initialize the $jobTitles variable

		// Pass the $classifications variable to the view
		return view('courselist', compact('classifications', 'details', 'courses', 'employees', 'filteredEmployees', 'affiliations', 'jobTitles'));
	}

	public function filter(Request $request)
    {
        $affiliationId = $request->input('affiliationId');
        $jobId = $request->input('jobId');
        $fullname = $request->input('fullname');
        $employeeCode = $request->input('employee_code');
        $courseClassificationId = $request->input('course_classification_id');
        $courseClassificationDetailsId = $request->input('course_classification_details_id');
        $courseId = $request->input('course_id');

        // Query the filtered employees
        $employeesQuery = EmployeeInformation::query();

        if ($affiliationId) {
            $employeesQuery->whereHas('employee_affiliation', function ($query) use ($affiliationId) {
                $query->where('affiliation_id', $affiliationId);
            });
        }

        if ($jobId) {
            $employeesQuery->whereHas('employee_affiliation', function ($query) use ($jobId) {
                $query->where('job_id', $jobId);
            });
        }

        if ($fullname) {
            $employeesQuery->where('fullname', 'LIKE', '%' . $fullname . '%');
        }

        if ($employeeCode) {
            $employeesQuery->where('employee_code', 'LIKE', '%' . $employeeCode . '%');
        }

        $filteredEmployees = $employeesQuery->get();

        // Fetch the necessary data
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $courses = CourseInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();

        // Return the view with the required data
        return view('employeeinquiry', compact('classifications', 'details', 'courses', 'affiliations', 'jobTitles', 'filteredEmployees'));
    }

	public function settings(Request $request)
	{
		$attribute = null;
		$classifications = CourseClassificationInformation::all();
		$details = CourseClassificationDetailInformation::all();
		$employees = EmployeeInformation::all();
		$affiliations = AffiliationInformation::all();
		$jobTitles = JobInformation::all();
		$courses = CourseInformation::all();

		$employeesQuery = EmployeeInformation::query();


		$employees = EmployeeInformation::query();

		if ($request->affiliation_code || $request->job) {
			$employees = $employees->whereHas('employee_affiliation', function ($query) use ($request) {
				if ($request->affiliation_code) {
					$query->where('affiliation_code', $request->affiliation_code);
				}
				if ($request->job) {
					$query->where('job_id', $request->job);
				}
			});
		}

		if ($request->employee_code) {
			$employees = $employees->where('employee_code', 'LIKE', '%' . $request->employee_code . '%');
		}
		if ($request->fullname) {
			$employees = $employees->where('fullname', 'LIKE', '%' . $request->fullname . '%');
		}
		$employees = $employees->get();

		return view('coursesettings', compact('classifications', 'details', 'courses', 'affiliations', 'employees', 'jobTitles'));
	}

	public function store(Request $request)
	{
		try {
			DB::beginTransaction();
			foreach ($request->courses as $course_id) {
				$course = CourseInformation::where('course_id', $course_id)->first();
				if ($course) {
					foreach ($request->employees as $employee_id) {
						$employee = EmployeeInformation::where('employee_id', $employee_id)->first();
						CourseScheduleResultsInformation::create([
							'course_id' => $course->course_id,
							'company_id' => $course->company_id,
							'employee_id' => $employee->employee_id,
							'schedule_course' => null,
							'course_information' => null,
							'deadline_enrollment' => Carbon::parse($request->deadline)->format('Y-m-d'),
							'todo_progress' => null,
							'todo_complete' => null,
							'number_test_conducted' => null,
							'first_test_correct_answer_rate' => null,
							'latest_test_number_correct_answer' => null,
							'latest_test_accuracy_rate' => null,
						]);
					}
				}

			}
			DB::commit();
			return redirect()->route('confirm-courses.index');
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}

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


	public function todoAnswerForm(Request $request, $course_id)
	{
		$user = auth()->guard('employee')->user();
		if ($user) {
			$user_id = $user->employee_id;
		} else {
			$user = auth()->user();
			$user_id = $user->id;
		}
		$course = CourseInformation::where('course_id', $course_id)->with('todo.choices')->first();
		$employee = EmployeeInformation::where('employee_id', $user_id)->first();

		$answer = [];
		for ($i = 0; $i < count($course->todo); $i++) {
			$answer[$i]['choice'] = "";
		}

		$dataTodoAnswer = json_encode(['todos' => $course->todo, 'answer' => $answer]);
		return view('course_information.todo-answer', compact('course', 'employee', 'dataTodoAnswer'));
	}

	// public function todoAnswerForm(Request $request, $course_id)
	// {
	// 	$user = auth()->guard('employee')->user();
	// 	if ($user) {
	// 		$user_id = $user->employee_id;
	// 	} else {
	// 		$user = auth()->user();
	// 		$user_id = $user->id;
	// 	}
	// 	$course = CourseInformation::where('course_id', $course_id)->with('todo.choices')->first();
	// 	$employee = EmployeeInformation::where('employee_id', $user_id)->first();

	// 	$answer = [];
	// 	for ($i = 0; $i < count($course->todo); $i++) {
	// 		$answer[$i]['choice'] = "";
	// 	}

	// 	$dataTodoAnswer = json_encode(['todos' => $course->todo, 'answer' => $answer]);
	// 	return view('course_information.todo-answer', compact('course', 'employee', 'dataTodoAnswer'));
	// }


}
