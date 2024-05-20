<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Storage;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\CourseClassificationInformation;

class CompanyInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = CompanyInformation::all();
        return view('company_information.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi apakah file ikon telah dipilih
        if ($request->hasFile('icon_storage_file_path') && $request->hasFile('teaching_material_storage_file_path')) {
            // Simpan file ikon
            $iconPath = $request->file('icon_storage_file_path')->store('public/icons/');
            // Simpan file material pengajaran
            $materialPath = $request->file('teaching_material_storage_file_path')->store('public/teaching/');

            // Tambahkan nilai 'icon_storage_file_path' dan 'teaching_material_storage_file_path' ke data perusahaan sebelum disimpan
            $companyData = $request->all();
            $companyData['icon_storage_file_path'] = Storage::url($iconPath); // Simpan path relatif ke database
            $companyData['teaching_material_storage_file_path'] = Storage::url($materialPath); // Simpan path relatif ke database

            // Buat perusahaan baru
            CompanyInformation::create($companyData);

            return redirect()->route('company-information.index')->with('success', 'Company created successfully');
        } else {
            // Jika file tidak dipilih, kembalikan ke formulir pembuatan perusahaan dengan pesan kesalahan
            return back()->withInput()->withErrors(['icon_storage_file_path' => 'Please select an icon file.', 'teaching_material_storage_file_path' => 'Please select a teaching material file.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = CompanyInformation::find($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = CompanyInformation::find($id);
        return view('company-information.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $company = CompanyInformation::find($id);
        $company->update($request->all());
        return redirect()->route('company-information.index')->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus terlebih dahulu semua data affiliasi terkait
        AffiliationInformation::where('company_id', $id)->delete();
    
        // Hapus terlebih dahulu semua data klasifikasi kursus terkait
        CourseClassificationInformation::where('company_id', $id)->delete();
    
        // Setelah semua data terkait dihapus, baru hapus perusahaan
        CompanyInformation::destroy($id);
    
        return redirect()->route('company-information.index')->with('success', 'Company deleted successfully');
    }
    

}
