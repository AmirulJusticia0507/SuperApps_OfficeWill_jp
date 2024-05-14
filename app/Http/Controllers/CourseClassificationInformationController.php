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
        $companies = CompanyInformation::all(); // Mengambil daftar perusahaan
        return view('course_classification.index', compact('classifications', 'companies'));
    }
    
    protected $primaryKey = 'course_classification_id';


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
            'company_name' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
            'icon_file_path' => 'required', // Anda mungkin ingin memvalidasi bahwa file ikon telah dipilih
        ]);
    
        // Cari company_id berdasarkan company_name
        $company = CompanyInformation::where('company_name', $request->input('company_name'))->firstOrFail();
    
        // Menambahkan data ke dalam database
        $classification = new CourseClassificationInformation();
        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $request->input('classification_name');
        // Handling file upload for icon file path
        if ($request->hasFile('icon_file_path')) {
            $classification->icon_file_path = $request->file('icon_file_path')->store('icon_files', 'public');
        }
        $classification->displayorder = $request->input('display_order');
        $classification->save();
    
        return redirect()->route('classifications.index')->with('success', 'Classification created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classification = CourseClassificationInformation::findOrFail($id);
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
            'company_name' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
        ]);
    
        // Temukan klasifikasi yang ingin diperbarui
        $classification = CourseClassificationInformation::findOrFail($id);
    
        // Cari company_id berdasarkan company_name
        $company = CompanyInformation::where('company_name', $request->input('company_name'))->firstOrFail();
    
        // Update data klasifikasi
        $classification->company_id = $company->company_id;
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
        $classification = CourseClassificationInformation::findOrFail($id);
        $classification->delete();
        return redirect()->route('classifications.index')->with('success', 'Classification deleted successfully');
    }
}
