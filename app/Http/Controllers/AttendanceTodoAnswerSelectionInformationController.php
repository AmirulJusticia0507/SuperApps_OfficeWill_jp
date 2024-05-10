<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceTodoAnswerSelectionInformation;

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
        AttendanceTodoAnswerSelectionInformation::create($request->all());
        return redirect()->route('attendances.index')->with('success', 'Attendance created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = AttendanceTodoAnswerSelectionInformation::find($id);
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
        $attendance = AttendanceTodoAnswerSelectionInformation::find($id);
        $attendance->update($request->all());
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AttendanceTodoAnswerSelectionInformation::destroy($id);
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }
}
