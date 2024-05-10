<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseClassificationInformation; // Import model

class CourseClassificationDetailInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = CourseClassificationDetailInformation::all();
        return view('course_classification_details.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch classifications
        $classifications = CourseClassificationInformation::all();

        return view('course_classification_details.create', compact('classifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseClassificationDetailInformation::create($request->all());
        return redirect()->route('details.index')->with('success', 'Detail created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = CourseClassificationDetailInformation::find($id);
        return view('course_classification_details.show', compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detail = CourseClassificationDetailInformation::find($id);
        return view('course_classification_details.edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $detail = CourseClassificationDetailInformation::find($id);
        $detail->update($request->all());
        return redirect()->route('details.index')->with('success', 'Detail updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseClassificationDetailInformation::destroy($id);
        return redirect()->route('details.index')->with('success', 'Detail deleted successfully');
    }
}
