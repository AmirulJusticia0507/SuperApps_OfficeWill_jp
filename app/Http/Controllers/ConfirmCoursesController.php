<?php

namespace App\Http\Controllers;

use App\Models\AttendanceTodoAnswerSelectionInformation;
use App\Models\AttendanceTodoItemAnswerInformation;
use App\Models\CourseInformation;
use App\Models\CourseClassificationDetailInformation;
use Illuminate\Http\Request;
use App\Models\CourseScheduleResultsInformation;
use App\Models\CourseTodoItemsChoiceInformation;
use App\Models\EmployeeInformation;
use Illuminate\Support\Facades\DB;

class ConfirmCoursesController extends Controller
{
	public function index()
	{
		$details = CourseClassificationDetailInformation::all();

		$user = auth()->guard('employee')->user();
		if ($user) {
			$user_id = $user->employee_id;
		} else {
			$user = auth()->user();
			$user_id = $user->id;
		}
		// Ambil data kursus yang perlu dikonfirmasi
		$scheduleResultCourses = CourseScheduleResultsInformation::where('employee_id', $user_id)->get();
		// Kirim data ke view confirmcourses.blade.php
		return view('confirmcourses.index', compact('scheduleResultCourses','details'));
	}

	public function attendence(Request $request, $course_id)
	{
		$user = auth()->guard('employee')->user();
		if ($user) {
			$user_id = $user->employee_id;
		} else {
			$user = auth()->user();
			$user_id = $user->id;
		}

		$details = CourseClassificationDetailInformation::all();
		$scheduleResultCourse = CourseScheduleResultsInformation::where('employee_id', $user_id)->whereHas('course', function ($query) use ($course_id) {
			$query->where('course_id', $course_id);
		})->first();

		return view('confirmcourses.attendence', compact('scheduleResultCourse','details'));
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
		$scheduleResultCourse = CourseScheduleResultsInformation::where('employee_id', $user_id)->whereHas('course', function ($query) use ($course_id) {
			$query->where('course_id', $course_id);
		})->with('course.todo.choices')->first();
		$employee = EmployeeInformation::where('employee_id', $user_id)->first();

		$answer = [];
		for ($i = 0; $i < count($scheduleResultCourse->course->todo); $i++) {
			$answer[$i]['choice'] = "";
		}

		switch ($scheduleResultCourse->course->todo_type) {
			case '1':
				$todoTypeTitle = 'Survey responses';
				$btnSaveText = 'Answer the survey';
				$confirmTitle = 'Post-class To-Do';
				$confirmHtml = 'Answer the questionnaire.<br>is this good?';
				break;
			case '2':
				$todoTypeTitle = 'Confirmation test';
				$btnSaveText = 'Grade tests';
				$confirmTitle = 'Post-class To-Do';
				$confirmHtml = 'Grade the tests.<br>is this good?';
				break;
			case '3':
				$todoTypeTitle = ' report';
				$btnSaveText = 'Submit a report';
				$confirmTitle = 'Post-class To-Do';
				$confirmHtml = 'Submit your report.<br>is this good?';
				break;
		}


		$dataTodoAnswer = json_encode(['todos' => $scheduleResultCourse->course->todo, 'answer' => $answer]);
		return view('confirmcourses.todo-answer', compact('scheduleResultCourse', 'employee', 'dataTodoAnswer', 'btnSaveText', 'todoTypeTitle', 'confirmTitle', 'confirmHtml'));
	}
	public function todoAnswerStore(Request $request)
	{
		// dd($request->all());
		try {
			DB::beginTransaction();

			$course = CourseInformation::where('course_id', $request->course_id)->first();
			if (!$course) {
				return "Invalid Course";
			}

			$user = auth()->guard('employee')->user();
			if ($user) {
				$user_id = $user->employee_id;
			} else {
				$user = auth()->user();
				$user_id = $user->id;
			}
			$employee = EmployeeInformation::where('employee_id', $user_id)->first();
			$course_schedule_result = CourseScheduleResultsInformation::where('attendance_setting_id', $request->attendance_settings_id)->first();

			$test_conducted = 0;

			$test_number_correct = 0;
			$test_rate_correct_answer = 0; // %

			foreach ($request->todo as $todo) {


				$choice = isset($todo['choices']) ? $todo['choices'] : null;

				switch ($todo['answer_type']) {
					case '1':
						AttendanceTodoItemAnswerInformation::create([
							'company_id' => $course->company_id,
							'employee_id' => $employee->employee_id,
							'course_id' => $course->course_id,
							'attendance_settings_id' => $course_schedule_result->attendance_setting_id,
							'todo_items_id' => $todo['todo_item_id'],
							'text_answer' => $todo['choices_text'] ?? null,
							'report' => $todo['report'] ?? null,
						]);
						break;
					case '2':
					case '3':
					case '4':
						if ($choice) {
							$item_choice = CourseTodoItemsChoiceInformation::where('todo_items_id', $todo['todo_item_id'])->where('todo_option_id', $choice)->first();
							if ($item_choice->test_choice_correct_answer) {
								$test_number_correct++;
							}

							AttendanceTodoAnswerSelectionInformation::create([
								'company_id' => $course->company_id,
								'employee_id' => $employee->employee_id,
								'course_id' => $course->course_id,
								'attendance_setting_id' => $course_schedule_result->attendance_setting_id,
								'todo_items_id' => $todo['todo_item_id'],
								'todo_option_id' => $choice,
								'selection' => $choice != null ? 1 : null,
								'other_text_answer' => $choice == 'others' ? $todo['text_answer'] : null,
							]);
						}

						break;
				}
				if ($choice != null || isset($todo['text_answer']) || isset($todo['choices_text'])) {
					$test_conducted++;
				}

			}
			$todo_progress = '2';
			$todo_complete = now();
			if ($request->save_type == 'temporary') {
				$todo_progress = '1';
				$todo_complete = null;
			}

			$test_rate_correct_answer = round(($test_number_correct / $test_conducted) * 100, 2);

			$course_result_data = [
				'todo_progress' => $todo_progress,
				'todo_complete' => $todo_complete,
				'number_test_conducted' => $test_conducted,
				'latest_test_number_correct_answer' => $test_number_correct,
				'latest_test_accuracy_rate' => $test_rate_correct_answer,
			];

			if ($course_schedule_result->first_test_correct_answer_rate == null || $course_schedule_result->first_test_correct_answer_rate == 0) {
				$course_result_data['first_test_number_correct_answer'] = $test_number_correct;
				$course_result_data['first_test_correct_answer_rate'] = $test_rate_correct_answer;
			}

			$course_schedule_result->where('attendance_setting_id', $request->attendance_settings_id)->update($course_result_data);

			DB::commit();

			switch ($request->todo_type) {
				case '1':
					$successMsg = 'Your survey has been completed.';
					break;
				case '3':
					$successMsg = 'The report submission is complete.';
					break;
			}

			if ($request->todo_type == '2') {
				return redirect()->route('confirm-courses.todo-answer.scoring', $course->course_id);
			} else {
				alert()->success('Post-class To-Do', $successMsg);
				return redirect()->route('confirm-courses.index');

			}

		} catch (\Throwable $th) {
			throw $th;
			DB::rollBack();
		}

	}

	public function todoAnswerScoring(Request $request, $course_id)
	{
		$user = auth()->guard('employee')->user();
		if ($user) {
			$user_id = $user->employee_id;
		} else {
			$user = auth()->user();
			$user_id = $user->id;
		}
		$scheduleResultCourse = CourseScheduleResultsInformation::where('employee_id', $user_id)->whereHas('course', function ($query) use ($course_id) {
			$query->where('course_id', $course_id);
		})->with('course.todo.choices')->first();
		$employee = EmployeeInformation::where('employee_id', $user_id)->first();

		$answer = [];
		for ($i = 0; $i < count($scheduleResultCourse->course->todo); $i++) {
			$answer[$i]['choice'] = "";
		}
		$attendenceItem = AttendanceTodoItemAnswerInformation::where('attendance_settings_id', $scheduleResultCourse->attendance_setting_id)->get();
		// dd($attendenceItem);
		$dataTodoAnswer = json_encode(['todos' => $scheduleResultCourse->course->todo, 'answer' => $answer]);
		return view('confirmcourses.todo-answer-scoring', compact('scheduleResultCourse', 'employee', 'dataTodoAnswer', 'attendenceItem'));

	}
}
