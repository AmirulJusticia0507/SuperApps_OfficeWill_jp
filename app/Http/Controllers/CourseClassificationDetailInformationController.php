<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Storage;

class CourseClassificationDetailInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = CourseClassificationDetailInformation::all();
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all();
        return view('course_classification_details.index', compact('details', 'classifications', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all();
        return view('course_classification_details.create', compact('classifications', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Course_classification_id' => 'required',
            'company_id' => 'required',
            'course_classification_detailsname' => 'required',
            'display_order' => 'required',
            'icon_file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate file input
        ]);

        $detail = new CourseClassificationDetailInformation();
        $detail->Course_classification_id = $request->input('Course_classification_id');
        $detail->company_id = $request->input('company_id');
        $detail->course_classification_detailsname = $request->input('course_classification_detailsname');
        $detail->display_order = $request->input('display_order');

        // Handle file upload
        if ($request->hasFile('icon_file_path')) {
            $imagePath = $request->file('icon_file_path')->store('course_classification_icons', 'public');
            $detail->icon_file_path = $imagePath;
        }

        $detail->save();

        return redirect()->route('details.index')->with('success', 'Detail created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $detail = CourseClassificationDetailInformation::find($id);
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all();
        return view('course_classification_details.edit', compact('detail', 'classifications', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Course_classification_id' => 'required',
            'company_id' => 'required',
            'course_classification_detailsname' => 'required',
            'display_order' => 'required',
            'icon_file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate file input
        ]);

        $detail = CourseClassificationDetailInformation::find($id);
        $detail->Course_classification_id = $request->input('Course_classification_id');
        $detail->company_id = $request->input('company_id');
        $detail->course_classification_detailsname = $request->input('course_classification_detailsname');
        $detail->display_order = $request->input('display_order');

        // Handle file upload
        if ($request->hasFile('icon_file_path')) {
            // Delete previous file if exists
            if ($detail->icon_file_path) {
                Storage::disk('public')->delete($detail->icon_file_path);
            }
            $imagePath = $request->file('icon_file_path')->store('course_classification_icons', 'public');
            $detail->icon_file_path = $imagePath;
        }

        $detail->save();

        return redirect()->route('details.index')->with('success', 'Detail updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = CourseClassificationDetailInformation::find($id);
        if ($detail) {
            // Delete associated file
            if ($detail->icon_file_path) {
                Storage::disk('public')->delete($detail->icon_file_path);
            }
            $detail->delete();
            return redirect()->route('details.index')->with('success', 'Detail deleted successfully');
        } else {
            return redirect()->route('details.index')->with('error', 'Detail not found');
        }
    }
}
