<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CompanyInformation;

class CourseClassificationInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all();
        return view('course_classification.index', compact('classifications', 'companies'));
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
        // Menentukan company_id berdasarkan pilihan yang dibuat dalam form
        $data = $request->all();
        $data['company_id'] = $request->input('company_id');
    
        // Simpan data ke dalam database
        CourseClassificationInformation::create($data);
    
        // Redirect ke halaman index
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
