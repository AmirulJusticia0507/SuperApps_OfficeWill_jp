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
		$modalId = 'create_company_information';
		return [
			'data' => ['modal_id' => $modalId],
			'html' => view('company_information.create', compact('modalId'))->render(),
		];
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		// Validasi apakah file ikon telah dipilih
		if ($request->hasFile('icon_storage_file_path')) {
			$iconPath = $request->file('icon_storage_file_path')->store('public/icons/');

			$companyData = $request->all();
			$companyData['login_screen_url'] = '/login/' . $companyData['company_username'];
			$companyData['icon_storage_file_path'] = Storage::url($iconPath);
			$companyData['teaching_material_storage_file_path'] = '/storage/' . $companyData['company_username'];

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
		return view('company.edit', compact('company'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$request->validate([
			'company_name' => 'required',
		]);

		$company = CompanyInformation::find($id);
		if ($company) {
			// Validasi apakah file ikon telah dipilih
			if ($request->hasFile('icon_storage_file_path')) {
				// Simpan file ikon
				$iconPath = $request->file('icon_storage_file_path')->store('public/icons/');
				$company->icon_storage_file_path = Storage::url($iconPath); // Simpan path relatif ke database
			}

			// Update data perusahaan
			$company->company_name = $request->input('company_name');
			$company->save();

			return redirect()->route('company-information.index')->with('success', 'Company updated successfully');
		} else {
			return back()->withErrors(['edit_error' => 'Company not found.']);
		}
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
