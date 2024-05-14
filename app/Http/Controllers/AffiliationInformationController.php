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
        $companies = CompanyInformation::all(); // Ambil data perusahaan
        return view('affiliation_information.index', compact('affiliations', 'companies')); // Kirim data perusahaan ke view
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
// Fungsi Create
public function store(Request $request)
{
    // Lakukan validasi untuk memastikan input tidak kosong
    $request->validate([
        'company_name' => 'required',
        'affiliation_code' => 'required',
        'affiliation_name' => 'required',
        'display_order' => 'required',
        'organization_type' => 'required',
    ]);

    // Temukan perusahaan berdasarkan ID yang dipilih
    $company = CompanyInformation::find($request->input('company_name'));

    // Pastikan perusahaan ditemukan
    if ($company) {
        // Buat data affiliasi
        $affiliationData = [
            'company_id' => $company->company_id,
            'affiliation_code' => $request->input('affiliation_code'),
            'affiliation_name' => $request->input('affiliation_name'),
            'display_order' => $request->input('display_order'),
            'organization_type' => $request->input('organization_type'),
        ];

        // Simpan data affiliasi
        AffiliationInformation::create($affiliationData);

        return redirect()->route('affiliation-information.index')->with('success', 'Affiliation created successfully');
    } else {
        // Redirect kembali ke form dengan pesan error jika perusahaan tidak ditemukan
        return back()->withErrors(['company_name' => 'Company not found.'])->withInput();
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
// Fungsi Edit
public function edit(string $id)
{
    $affiliation = AffiliationInformation::find($id);
    if ($affiliation) {
        return view('affiliation.edit', compact('affiliation'));
    } else {
        return back()->withErrors(['edit_error' => 'Affiliation not found.']);
    }
}

    /**
     * Update the specified resource in storage.
     */
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $affiliation = AffiliationInformation::find($id);
    $affiliation->update($request->all());
    return redirect()->route('affiliation-information.index')->with('success', 'Affiliation updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        if ($affiliation) {
            $affiliation->delete();
            return redirect()->route('affiliation-information.index')->with('success', 'Affiliation deleted successfully');
        } else {
            return back()->withErrors(['delete_error' => 'Affiliation not found.']);
        }
    }

    public function showCourseSettings()
    {
        $affiliations = AffiliationInformation::all();
        return view('coursesettings', compact('affiliations'));
    }

    public function resetForm()
    {
        // Redirect kembali ke halaman form dengan input yang telah di-reset
        return redirect()->route('affiliation-information.create');
    }

    public function delete(Request $request, string $id)
    {
        // Temukan data affiliasi yang akan dihapus
        $affiliation = AffiliationInformation::find($id);

        // Pastikan data ditemukan
        if ($affiliation) {
            // Hapus data
            $affiliation->delete();
            return redirect()->route('affiliation-information.index')->with('success', 'Affiliation deleted successfully');
        } else {
            // Redirect dengan pesan error jika data tidak ditemukan
            return back()->withErrors(['delete_error' => 'Affiliation not found.']);
        }
    }

}
