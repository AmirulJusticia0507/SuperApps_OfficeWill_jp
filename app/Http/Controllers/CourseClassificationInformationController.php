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
        return view('course_classification.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = CompanyInformation::all();
        return view('course_classification.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'company_id' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
        ]);

        // Menambahkan data ke dalam database
        $classification = new CourseClassificationInformation();
        $classification->company_id = $request->input('company_id');
        $classification->course_classification_name = $request->input('classification_name');
        // Handling file upload for icon file path, if needed
        $classification->icon_file_path = $request->file('icon_file_path')->store('icon_files', 'public');
        $classification->displayorder = $request->input('display_order');
        $classification->save();

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
        $companies = CompanyInformation::all();
        return view('course_classification.edit', compact('classification', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi request
        $request->validate([
            'company_id' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
        ]);

        // Temukan klasifikasi yang ingin diperbarui
        $classification = CourseClassificationInformation::find($id);

        // Update data klasifikasi
        $classification->company_id = $request->input('company_id');
        $classification->course_classification_name = $request->input('classification_name');
        // Handling file upload for icon file path, if needed
        if ($request->hasFile('icon_file_path')) {
            $classification->icon_file_path = $request->file('icon_file_path')->store('icon_files', 'public');
        }
        $classification->displayorder = $request->input('display_order');
        $classification->save();

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
