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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'company_name' => 'required',
            'classification_name' => 'required',
            'display_order' => 'required',
            'icon_file_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);
    
        // Cari company_id berdasarkan company_name
        $company = CompanyInformation::where('company_name', $request->input('company_name'))->firstOrFail();
    
        // Handling file upload for icon file path
        $iconPath = $request->file('icon_file_path')->store('public/icon'); // Simpan gambar ke direktori public/icon
    
        // Menambahkan data ke dalam database
        $classification = new CourseClassificationInformation();
        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $request->input('classification_name');
        $classification->icon_file_path = Storage::url($iconPath); // Simpan path relatif ke database
        $classification->displayorder = $request->input('display_order');
        $classification->save();
    
        return redirect()->route('course-classification.index')->with('success', 'Classification created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Temukan klasifikasi kursus yang ingin diedit
        $classification = CourseClassificationInformation::findOrFail($id);
        // Ambil semua perusahaan
        $companies = CompanyInformation::all();
        return view('course_classification.index', compact('classification', 'companies'));
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
    
        // Handling file upload for icon file path, if needed
        if ($request->hasFile('icon_file_path')) {
            $iconPath = $request->file('icon_file_path')->store('public/icon');
            $classification->icon_file_path = Storage::url($iconPath);
        }
    
        // Update data klasifikasi
        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $request->input('classification_name');
        $classification->displayorder = $request->input('display_order');
        $classification->save();
    
        return redirect()->route('course-classification.index')->with('success', 'Classification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan klasifikasi kursus yang ingin dihapus
        $classification = CourseClassificationInformation::findOrFail($id);
        // Hapus data
        $classification->delete();
        return redirect()->route('course-classification.index')->with('success', 'Classification deleted successfully');
    }
}
