<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseScheduleResultsInformation;
use App\Http\Controllers\Concerns\ValidatesModelInput;

class CourseScheduleResultsInformationController extends Controller
{
    use ValidatesModelInput;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = CourseScheduleResultsInformation::all();
        return view('course_schedule_results.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_schedule_results.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseScheduleResultsInformation::create($this->validatedModelInput($request, new CourseScheduleResultsInformation()));
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = CourseScheduleResultsInformation::find($id);
        return view('course_schedule_results.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = CourseScheduleResultsInformation::find($id);
        return view('course_schedule_results.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = CourseScheduleResultsInformation::findOrFail($id);
        $schedule->update($this->validatedModelInput($request, $schedule));
        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseScheduleResultsInformation::findOrFail($id)->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully');
    }
}
