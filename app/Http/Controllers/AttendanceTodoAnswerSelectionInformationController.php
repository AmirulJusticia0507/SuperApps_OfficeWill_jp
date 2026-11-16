<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceTodoAnswerSelectionInformation;
use App\Models\CourseInformation;
use App\Models\CourseScheduleResultsInformation;
use App\Models\CourseTodoItemInformation;
use App\Models\CourseTodoItemsChoiceInformation;
use App\Models\EmployeeInformation;

class AttendanceTodoAnswerSelectionInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = AttendanceTodoAnswerSelectionInformation::all();
        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer'],
            'course_id' => ['required', 'integer'],
            'attendance_setting_id' => ['required', 'integer'],
            'todo_items_id' => ['required', 'integer'],
            'todo_option_id' => ['required', 'integer'],
            'selection' => ['nullable', 'boolean'],
            'other_text_answer' => ['nullable', 'string', 'max:255'],
        ]);
        $employee = EmployeeInformation::findOrFail($data['employee_id']);
        $course = CourseInformation::findOrFail($data['course_id']);
        $todoItem = CourseTodoItemInformation::findOrFail($data['todo_items_id']);
        $choice = CourseTodoItemsChoiceInformation::findOrFail($data['todo_option_id']);
        abort_unless((int) $employee->company_id === (int) $course->company_id
            && (int) $todoItem->course_id === (int) $course->course_id
            && (int) $choice->todo_items_id === (int) $todoItem->todo_item_id, 422);
        CourseScheduleResultsInformation::where('attendance_setting_id', $data['attendance_setting_id'])
            ->where('employee_id', $employee->employee_id)
            ->where('course_id', $course->course_id)
            ->firstOrFail();

        AttendanceTodoAnswerSelectionInformation::create([
            'company_id' => $course->company_id,
            'employee_id' => $employee->employee_id,
            'course_id' => $course->course_id,
            'attendance_setting_id' => $data['attendance_setting_id'],
            'todo_items_id' => $todoItem->todo_item_id,
            'todo_option_id' => $data['todo_option_id'],
            'selection' => $data['selection'] ?? null,
            'other_text_answer' => $data['other_text_answer'] ?? '',
        ]);
        return redirect()->route('attendances.index')->with('success', 'Attendance created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = AttendanceTodoAnswerSelectionInformation::findOrFail($id);
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = AttendanceTodoAnswerSelectionInformation::find($id);
        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendance = AttendanceTodoAnswerSelectionInformation::findOrFail($id);
        $data = $request->validate([
            'todo_option_id' => ['sometimes', 'required', 'integer'],
            'selection' => ['sometimes', 'nullable', 'boolean'],
            'other_text_answer' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);
        if (isset($data['todo_option_id'])) {
            $choice = CourseTodoItemsChoiceInformation::findOrFail($data['todo_option_id']);
            abort_unless((int) $choice->todo_items_id === (int) $attendance->todo_items_id, 422);
        }
        $attendance->update($data);
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AttendanceTodoAnswerSelectionInformation::findOrFail($id)->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }
}
