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
use Illuminate\Support\Facades\Schema;

class CourseController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$companyId = $this->currentUserCompanyId();
		$classifications = $companyId ? CourseClassificationInformation::where('company_id', $companyId)->get() : collect();
		$details = $companyId ? CourseClassificationDetailInformation::where('company_id', $companyId)->get() : collect();
		$courses = $companyId ? CourseInformation::where('company_id', $companyId)->get() : collect();
		$filteredEmployees = [];
		$affiliations = $companyId ? AffiliationInformation::where('company_id', $companyId)->get() : collect();
		$employees = $companyId ? EmployeeInformation::where('company_id', $companyId)->get() : collect();
		$jobTitles = $companyId ? JobInformation::where('company_id', $companyId)->get() : collect();

		// Pass the $classifications variable to the view
		return view('courselist', compact('classifications', 'details', 'courses', 'employees', 'filteredEmployees', 'affiliations', 'jobTitles'));
	}

	public function filter(Request $request)
    {
        $courseClassificationId = $request->input('course_classification_id');
        $courseClassificationDetailsId = $request->input('course_classification_details_id');
        $companyId = $this->currentUserCompanyId();

        $coursesQuery = CourseInformation::query();
        if ($companyId) {
            $coursesQuery->where('company_id', $companyId);
        } else {
            $coursesQuery->whereRaw('1 = 0');
        }
        if ($courseClassificationId) {
            // The deployed PostgreSQL schema still uses the legacy quoted column name.
            $coursesQuery->where('Course_classification_id', $courseClassificationId);
        }
        if ($courseClassificationDetailsId) {
            $coursesQuery->where('course_classification_details_id', $courseClassificationDetailsId);
        }
        if ($request->filled('course_name')) {
            $coursesQuery->where('coursename', 'LIKE', '%' . $request->input('course_name') . '%');
        }
        $courses = $coursesQuery->get();

        // Fetch the necessary data
        $classifications = $companyId ? CourseClassificationInformation::where('company_id', $companyId)->get() : collect();
        $details = $companyId ? CourseClassificationDetailInformation::where('company_id', $companyId)->get() : collect();
        $affiliations = $companyId ? AffiliationInformation::where('company_id', $companyId)->get() : collect();
        $employees = $companyId ? EmployeeInformation::where('company_id', $companyId)->get() : collect();
        $jobTitles = $companyId ? JobInformation::where('company_id', $companyId)->get() : collect();

        return view('courselist', compact('classifications', 'details', 'courses', 'employees', 'affiliations', 'jobTitles'));
    }

	private function currentUserCompanyId(): ?int
	{
		$employee = auth()->guard('employee')->user();
		if (!$employee && ($user = auth()->guard('web')->user())) {
			$employee = EmployeeInformation::where('email', $user->email)->first();
		}

		return $employee?->company_id === null ? null : (int) $employee->company_id;
	}

	public function settings(Request $request)
	{
		$attribute = null;
		// Course master tables are supplied by the legacy SQL dump, not migrations.
		$classifications = Schema::hasTable('course_classification_information')
			? CourseClassificationInformation::all()
			: collect();
		$details = Schema::hasTable('course_classification_detail_information')
			? CourseClassificationDetailInformation::all()
			: collect();
		$employees = EmployeeInformation::all();
		$affiliations = AffiliationInformation::all();
		$jobTitles = JobInformation::all();
		$courses = Schema::hasTable('course_information')
			? CourseInformation::all()
			: collect();

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
