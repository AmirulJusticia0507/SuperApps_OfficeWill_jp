<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Storage;
class CourseClassificationInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all(); // Mengambil daftar perusahaan
        return view('course_classification.index', compact('classifications', 'companies'));
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
        $request->validate([
            'company_name' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
            'icon_file_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = CompanyInformation::where('company_name', $request->input('company_name'))->firstOrFail();
        $iconPath = $request->file('icon_file_path')->store('public/icon');
        
        $classification = new CourseClassificationInformation();
        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $request->input('classification_name');
        $classification->icon_file_path = Storage::url($iconPath);
        $classification->displayorder = $request->input('display_order');
        $classification->save();

        return redirect()->route('course-classification.index')->with('success', 'Classification created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $classification = CourseClassificationInformation::findOrFail($id);
        $company = CompanyInformation::find($classification->company_id);
        
        return response()->json([
            'course_classification_id' => $classification->course_classification_id,
            'course_classification_name' => $classification->course_classification_name,
            'displayorder' => $classification->displayorder,
            'company_id' => $company->company_id,
            'company_name' => $company->company_name,
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
        ]);

        $classification = CourseClassificationInformation::findOrFail($id);
        $company = CompanyInformation::where('company_name', $request->input('company_name'))->firstOrFail();

        if ($request->hasFile('icon_file_path')) {
            $iconPath = $request->file('icon_file_path')->store('public/icon');
            $classification->icon_file_path = Storage::url($iconPath);
        }

        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $request->input('classification_name');
        $classification->displayorder = $request->input('display_order');
        $classification->save();

        return redirect()->route('course-classification.index')->with('success', 'Classification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classification = CourseClassificationInformation::findOrFail($id);
        $classification->delete();
        return redirect()->route('course-classification.index')->with('success', 'Classification deleted successfully');
    }
    
}
