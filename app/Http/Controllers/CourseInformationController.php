<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseInformation;

class CourseInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = CourseInformation::all();
        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseInformation::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = CourseInformation::find($id);
        return view('course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = CourseInformation::find($id);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = CourseInformation::find($id);
        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseInformation::destroy($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
