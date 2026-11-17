<?php

namespace App\Http\Controllers;

use App\Models\AttendanceTodoAnswerSelectionInformation;
use App\Models\AttendanceTodoItemAnswerInformation;
use App\Models\CourseInformation;
use App\Models\CourseScheduleResultsInformation;
use App\Models\EmployeeInformation;

class CourseInquiryController extends Controller
{
	public function index()
	{
		$courses = CourseInformation::with('classification', 'classification_detail')->orderBy('coursename')->get();

		return view('inquiries.courses', compact('courses'));
	}

	public function courseEnrollments(int $courseId)
	{
		$course = CourseInformation::with('classification', 'classification_detail', 'todo.choices')->findOrFail($courseId);
		$enrollments = CourseScheduleResultsInformation::where('course_id', $course->course_id)
			->with('employee.employee_affiliation.affiliation', 'employee.employee_affiliation.job')
			->orderByDesc('attendance_setting_id')
			->get();

		return view('inquiries.course-enrollments', compact('course', 'enrollments'));
	}

	public function employeeAttendance(int $employeeId)
	{
		$employee = EmployeeInformation::with('employee_affiliation.affiliation', 'employee_affiliation.job')->findOrFail($employeeId);
		$enrollments = CourseScheduleResultsInformation::where('employee_id', $employee->employee_id)
			->with('course.classification', 'course.classification_detail')
			->orderByDesc('attendance_setting_id')
			->get();

		return view('inquiries.employee-attendance', compact('employee', 'enrollments'));
	}

	public function responses(int $attendanceSettingId)
	{
		$enrollment = CourseScheduleResultsInformation::with('course.classification', 'course.classification_detail', 'course.todo.choices')
			->where('attendance_setting_id', $attendanceSettingId)
			->firstOrFail();
		$employee = EmployeeInformation::findOrFail($enrollment->employee_id);
		$textAnswers = AttendanceTodoItemAnswerInformation::where('attendance_settings_id', $enrollment->attendance_setting_id)
			->where('course_id', $enrollment->course_id)
			->get()
			->keyBy('todo_items_id');
		$selectionAnswers = AttendanceTodoAnswerSelectionInformation::where('attendance_setting_id', $enrollment->attendance_setting_id)
			->where('course_id', $enrollment->course_id)
			->get()
			->groupBy('todo_items_id');

		return view('inquiries.course-responses', compact('enrollment', 'employee', 'textAnswers', 'selectionAnswers'));
	}
}
