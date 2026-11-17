<?php

namespace App\Http\Controllers;

use App\Models\AttendanceTodoAnswerSelectionInformation;
use App\Models\AttendanceTodoItemAnswerInformation;
use App\Models\CourseInformation;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use App\Models\CourseScheduleResultsInformation;
use App\Models\CourseTodoItemsChoiceInformation;
use App\Models\EmployeeInformation;
use App\Mail\CourseCompleted;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ConfirmCoursesController extends Controller
{
	public function index()
	{
		$user = auth()->guard('employee')->user();
		if ($user) {
			$user_id = $user->employee_id;
		} else {
			$user = auth()->user();
			$user_id = $user->id;
		}
		// Database lama menyediakan tabel ini melalui dump SQL, bukan migration.
		// Tampilkan daftar kosong sampai dump/migration kursus tersedia.
		$scheduleResultCourses = Schema::hasTable('course_schedule_results_information')
			? CourseScheduleResultsInformation::where('employee_id', $user_id)->get()
			: collect();
		// Kirim data ke view confirmcourses.blade.php
		return view('confirmcourses.index', compact('scheduleResultCourses'));
	}

	public function certificate(int $attendance_setting_id)
	{
		$user = auth()->guard('employee')->user();
		$employeeId = $user ? $user->employee_id : auth()->id();
		$enrollment = CourseScheduleResultsInformation::where('attendance_setting_id', $attendance_setting_id)
			->where('employee_id', $employeeId)
			->where('todo_progress', '2')
			->whereNotNull('todo_complete')
			->firstOrFail();

		$course = CourseInformation::findOrFail($enrollment->course_id);
		$employee = EmployeeInformation::findOrFail($enrollment->employee_id);
		$company = CompanyInformation::find($enrollment->company_id);

		return view('confirmcourses.certificate', [
			'course' => $course,
			'employee' => $employee,
			'company' => $company,
			'completedAt' => Carbon::parse($enrollment->todo_complete),
			'certificateNumber' => sprintf('DEP-%04d-%04d-%06d', $enrollment->company_id, $enrollment->course_id, $enrollment->attendance_setting_id),
		]);
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

		$scheduleResultCourse = CourseScheduleResultsInformation::where('employee_id', $user_id)->whereHas('course', function ($query) use ($course_id) {
			$query->where('course_id', $course_id);
		})->first();

		return view('confirmcourses.attendence', compact('scheduleResultCourse'));
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
	public function todoAnswerStore(Request $request, $course_id)
	{
		$data = $request->validate([
			'course_id' => ['required', 'integer', 'in:' . $course_id],
			'attendance_settings_id' => ['required', 'integer'],
			'todo_type' => ['required', 'in:1,2,3'],
			'save_type' => ['nullable', 'in:temporary'],
			'todo' => ['sometimes', 'array', 'max:100'],
			'todo.*.todo_item_id' => ['required', 'integer'],
			'todo.*.answer_type' => ['required', 'in:1,2,3,4'],
			'todo.*.choices' => ['nullable'],
			'todo.*.choices_text' => ['nullable', 'string', 'max:10000'],
			'todo.*.text_answer' => ['nullable', 'string', 'max:10000'],
			'todo.*.report' => ['nullable', 'string', 'max:10000'],
		]);

		$authenticatedEmployee = auth()->guard('employee')->user();
		$employeeId = $authenticatedEmployee ? $authenticatedEmployee->employee_id : auth()->id();
		$course = CourseInformation::findOrFail($course_id);
		abort_unless((string) $course->todo_type === (string) $data['todo_type'], 422);
		$schedule = CourseScheduleResultsInformation::where('attendance_setting_id', $data['attendance_settings_id'])
			->where('employee_id', $employeeId)
			->where('course_id', $course->course_id)
			->firstOrFail();
		$todoItems = $course->todo->keyBy('todo_item_id');
		$submittedItemIds = collect($data['todo'] ?? [])->pluck('todo_item_id')->map('strval')->sort()->values();
		$expectedItemIds = $todoItems->keys()->map('strval')->sort()->values();
		abort_unless($submittedItemIds->all() === $expectedItemIds->all(), 422);
		$wasAlreadyCompleted = (string) $schedule->todo_progress === '2';
		$testConducted = 0;
		$testNumberCorrect = 0;

		DB::transaction(function () use ($data, $course, $schedule, $employeeId, $todoItems, &$testConducted, &$testNumberCorrect) {
			foreach ($data['todo'] ?? [] as $answer) {
				$item = $todoItems->get($answer['todo_item_id']);
				abort_unless($item && (string) $item->answer_type === (string) $answer['answer_type'], 422);
				$choices = $answer['choices'] ?? null;
				$choices = is_array($choices) ? $choices : ($choices === null || $choices === '' ? [] : [$choices]);

				if ((string) $answer['answer_type'] === '1') {
					$text = $answer['choices_text'] ?? null;
					abort_unless((string) $item->required_settings !== '1' || filled($text), 422);
					AttendanceTodoItemAnswerInformation::create([
						'company_id' => $course->company_id,
						'employee_id' => $employeeId,
						'course_id' => $course->course_id,
						'attendance_settings_id' => $schedule->attendance_setting_id,
						'todo_items_id' => $item->todo_item_id,
						'text_answer' => $text,
						'report' => $answer['report'] ?? null,
					]);
					$testConducted += filled($text) ? 1 : 0;
					continue;
				}
				abort_unless((string) $item->required_settings !== '1' || count($choices) > 0, 422);

				foreach ($choices as $choiceId) {
					abort_unless(ctype_digit((string) $choiceId), 422);
					$choice = CourseTodoItemsChoiceInformation::where('todo_items_id', $item->todo_item_id)
						->where('todo_option_id', $choiceId)->firstOrFail();
					AttendanceTodoAnswerSelectionInformation::create([
						'company_id' => $course->company_id,
						'employee_id' => $employeeId,
						'course_id' => $course->course_id,
						'attendance_setting_id' => $schedule->attendance_setting_id,
						'todo_items_id' => $item->todo_item_id,
						'todo_option_id' => $choice->todo_option_id,
						'selection' => 1,
						'other_text_answer' => strtolower($choice->choices) === 'others' ? ($answer['text_answer'] ?? null) : null,
					]);
					$testNumberCorrect += (bool) $choice->test_choice_correct_answer ? 1 : 0;
				}
				$testConducted += count($choices) > 0 ? 1 : 0;
			}

			$accuracy = $testConducted > 0 ? round(($testNumberCorrect / $testConducted) * 100, 2) : 0;
			$schedule->update([
				'todo_progress' => ($data['save_type'] ?? null) === 'temporary' ? '1' : '2',
				'todo_complete' => ($data['save_type'] ?? null) === 'temporary' ? null : now(),
				'number_test_conducted' => $testConducted,
				'latest_test_number_correct_answer' => $testNumberCorrect,
				'latest_test_accuracy_rate' => $accuracy,
			]);
			if (!$schedule->first_test_correct_answer_rate) {
				$schedule->update([
					'first_test_number_correct_answer' => $testNumberCorrect,
					'first_test_correct_answer_rate' => $accuracy,
				]);
			}
		});

		if (!$wasAlreadyCompleted && ($data['save_type'] ?? null) !== 'temporary') {
			$employee = EmployeeInformation::find($employeeId);
			if ($employee && filter_var($employee->email, FILTER_VALIDATE_EMAIL)) {
				try {
					Mail::to($employee->email)->send(new CourseCompleted(
						$employee->fullname,
						$course->coursename,
						Carbon::parse($schedule->fresh()->todo_complete)->format('Y-m-d H:i'),
						route('confirm-courses.certificate', $schedule->attendance_setting_id)
					));
				} catch (Throwable $exception) {
					Log::error('Course completion email could not be sent.', [
						'employee_id' => $employeeId,
						'course_id' => $course->course_id,
						'exception' => get_class($exception),
					]);
				}
			}
		}

		if ((string) $data['todo_type'] === '2') {
			return redirect()->route('confirm-courses.todo-answer.scoring', $course->course_id);
		}

		$successMessage = (string) $data['todo_type'] === '1'
			? 'Your survey has been completed.'
			: 'The report submission is complete.';
		alert()->success('Post-class To-Do', $successMessage);
		return redirect()->route('confirm-courses.index');
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
