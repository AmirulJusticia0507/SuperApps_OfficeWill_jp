<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceTodoItemAnswerInformation;
use App\Models\CourseInformation;
use App\Models\CourseScheduleResultsInformation;
use App\Models\CourseTodoItemInformation;
use App\Models\EmployeeInformation;

class AttendanceTodoItemAnswerInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = AttendanceTodoItemAnswerInformation::all();
        return view('answer.index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('answer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer'],
            'course_id' => ['required', 'integer'],
            'attendance_settings_id' => ['required', 'integer'],
            'todo_items_id' => ['required', 'integer'],
            'text_answer' => ['nullable', 'string', 'max:255'],
            'report' => ['nullable', 'string'],
        ]);
        $employee = EmployeeInformation::findOrFail($data['employee_id']);
        $course = CourseInformation::findOrFail($data['course_id']);
        $todoItem = CourseTodoItemInformation::findOrFail($data['todo_items_id']);
        abort_unless((int) $employee->company_id === (int) $course->company_id
            && (int) $todoItem->course_id === (int) $course->course_id, 422);
        CourseScheduleResultsInformation::where('attendance_setting_id', $data['attendance_settings_id'])
            ->where('employee_id', $employee->employee_id)
            ->where('course_id', $course->course_id)
            ->firstOrFail();

        AttendanceTodoItemAnswerInformation::create([
            'company_id' => $course->company_id,
            'employee_id' => $employee->employee_id,
            'course_id' => $course->course_id,
            'attendance_settings_id' => $data['attendance_settings_id'],
            'todo_items_id' => $todoItem->todo_item_id,
            'text_answer' => $data['text_answer'] ?? null,
            'report' => $data['report'] ?? null,
        ]);
        return redirect()->route('answers.index')->with('success', 'Answer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $answer = AttendanceTodoItemAnswerInformation::findOrFail($id);
        return view('answer.show', compact('answer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $answer = AttendanceTodoItemAnswerInformation::find($id);
        return view('answer.edit', compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $answer = AttendanceTodoItemAnswerInformation::findOrFail($id);
        $data = $request->validate([
            'text_answer' => ['sometimes', 'nullable', 'string', 'max:255'],
            'report' => ['sometimes', 'nullable', 'string'],
        ]);
        $answer->update($data);
        return redirect()->route('answers.index')->with('success', 'Answer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AttendanceTodoItemAnswerInformation::findOrFail($id)->delete();
        return redirect()->route('answers.index')->with('success', 'Answer deleted successfully');
    }
}
