<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;

class CourseClassificationInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = CourseClassificationInformation::all();
        return view('course_classification.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_classification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menambahkan company_id ke dalam data yang akan disimpan
        $data = $request->all();
        $data['company_id'] = // isikan dengan nilai company_id yang sesuai;

        CourseClassificationInformation::create($data);
        return redirect()->route('classifications.index')->with('success', 'Classification created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classification = CourseClassificationInformation::find($id);
        return view('course_classification.show', compact('classification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classification = CourseClassificationInformation::find($id);
        return view('course_classification.edit', compact('classification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classification = CourseClassificationInformation::find($id);
        $classification->update($request->all());
        return redirect()->route('classifications.index')->with('success', 'Classification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseClassificationInformation::destroy($id);
        return redirect()->route('classifications.index')->with('success', 'Classification deleted successfully');
    }
}
