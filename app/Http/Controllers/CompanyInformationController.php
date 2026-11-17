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
		return view('company_information.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$validated = $request->validate([
			'company_name' => ['required', 'string', 'max:20'],
			'company_username' => ['required', 'string', 'alpha_dash', 'max:150'],
			'icon_storage_file_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
		]);

		$iconPath = $request->file('icon_storage_file_path')->store('public/icons');
		$companyName = $validated['company_username'];

		CompanyInformation::create([
			'company_name' => $validated['company_name'],
			'login_screen_url' => '/login/' . $companyName,
			'icon_storage_file_path' => Storage::url($iconPath),
			'teaching_material_storage_file_path' => '/storage/' . $companyName,
		]);

		return redirect()->route('company-information.index')->with('success', 'Company created successfully');
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
		$company = CompanyInformation::findOrFail($id);
		return view('company_information.edit', compact('company'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$request->validate([
			'company_name' => 'required',
		]);

		$validated = $request->validate([
			'company_name' => ['required', 'string', 'max:20'],
			'icon_storage_file_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
		]);

		$company = CompanyInformation::findOrFail($id);
		if ($request->hasFile('icon_storage_file_path')) {
			$iconPath = $request->file('icon_storage_file_path')->store('public/icons');
			$company->icon_storage_file_path = Storage::url($iconPath);
		}

		$company->company_name = $validated['company_name'];
		$company->save();

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
