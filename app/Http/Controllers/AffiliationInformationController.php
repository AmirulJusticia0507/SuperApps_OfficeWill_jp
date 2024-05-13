<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliationInformation;
use App\Models\CompanyInformation;

class AffiliationInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affiliations = AffiliationInformation::all();
        return view('affiliation_information.index', compact('affiliations'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('affiliation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Lakukan validasi untuk memastikan input tidak kosong
        $request->validate([
            'company_name_search' => 'required',
            'affiliation_code' => 'required',
            'affiliation_name' => 'required',
            'display_order' => 'required',
            'organization_type' => 'required',
        ]);
    
        // Cari company berdasarkan nama yang dimasukkan
        $company = CompanyInformation::where('company_name', $request->input('company_name_search'))->first();
    
        // Pastikan company ditemukan
        if ($company) {
            // Buat data affiliation
            $affiliationData = [
                'company_id' => $company->company_id,
                'affiliation_code' => $request->input('affiliation_code'),
                'affiliation_name' => $request->input('affiliation_name'),
                'display_order' => $request->input('display_order'),
                'organization_type' => $request->input('organization_type'),
            ];
    
            // Simpan data affiliation
            AffiliationInformation::create($affiliationData);
    
            return redirect()->route('affiliation-information.index')->with('success', 'Affiliation created successfully');
        } else {
            // Redirect kembali ke form dengan pesan error jika company tidak ditemukan
            return back()->withErrors(['company_name_search' => 'Company not found.'])->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        return view('affiliation.show', compact('affiliation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        return view('affiliation.edit', compact('affiliation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        $affiliation->update($request->all());
        return redirect()->route('affiliations.index')->with('success', 'Affiliation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AffiliationInformation::destroy($id);
        return redirect()->route('affiliations.index')->with('success', 'Affiliation deleted successfully');
    }

    public function showCourseSettings()
    {
        $affiliations = AffiliationInformation::all();
        return view('coursesettings', compact('affiliations'));
    }
}
