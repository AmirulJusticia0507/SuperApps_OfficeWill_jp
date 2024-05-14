<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseClassificationInformation; // Import model
use App\Models\CompanyInformation;

class CourseClassificationDetailInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = CourseClassificationDetailInformation::all();
        $classifications = CourseClassificationInformation::all(); // Mendapatkan semua klasifikasi kursus
        $companies = CompanyInformation::all(); // Mengambil daftar perusahaan
        return view('course_classification_details.index', compact('details', 'classifications', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Fetch classifications dan companies
    $classifications = CourseClassificationInformation::all();
    $companies = CompanyInformation::all();
    return view('course_classification_details.create', compact('classifications', 'companies'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Course_classification_id' => 'required',
            'company_id' => 'required', // Pastikan company_id tidak boleh null
            'course_classification_detailsname' => 'required',
            'display_order' => 'required'
        ]);

        // Buat data baru berdasarkan request
        $detail = new CourseClassificationDetailInformation();
        $detail->Course_classification_id = $request->input('Course_classification_id');
        $detail->company_id = $request->input('company_id');
        $detail->course_classification_detailsname = $request->input('course_classification_detailsname');
        $detail->display_order = $request->input('display_order');

        // Simpan data ke database
        $detail->save();

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
        // Temukan detail kursus yang ingin diedit
        $detail = CourseClassificationDetailInformation::find($id);
        // Ambil semua klasifikasi kursus dan daftar perusahaan
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all();
        return view('course_classification_details.edit', compact('detail', 'classifications', 'companies'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'Course_classification_id' => 'required',
            'company_id' => 'required', // Pastikan company_id tidak boleh null
            'course_classification_detailsname' => 'required',
            'display_order' => 'required'
        ]);

        // Temukan data yang ingin diperbarui
        $detail = CourseClassificationDetailInformation::find($id);
        $detail->Course_classification_id = $request->input('Course_classification_id');
        $detail->company_id = $request->input('company_id');
        $detail->course_classification_detailsname = $request->input('course_classification_detailsname');
        $detail->display_order = $request->input('display_order');

        // Simpan perubahan
        $detail->save();

        return redirect()->route('details.index')->with('success', 'Detail updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan detail kursus yang ingin dihapus
        $detail = CourseClassificationDetailInformation::find($id);
        // Hapus data
        $detail->delete();
        return redirect()->route('details.index')->with('success', 'Detail deleted successfully');
    }
    
}
