<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliationInformation;
use App\Models\CompanyInformation;

class AffiliationInformationController extends Controller
{
    public function index()
    {
        $affiliations = AffiliationInformation::getAllAffiliations();
        $companies = CompanyInformation::all();
        return view('affiliation_information.index', compact('affiliations', 'companies'));
    }

    public function create()
    {
        $companies = CompanyInformation::all();
        return view('affiliation_information.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['required', 'integer'],
            'affiliation_code' => ['required', 'integer', 'unique:affiliation_information,affiliation_code'],
            'affiliation_name' => ['required', 'string', 'max:255'],
            'display_order' => ['required', 'integer', 'between:0,999'],
            'organization_type' => ['required', 'string', 'max:255'],
        ]);

        $company = CompanyInformation::findOrFail($data['company_name']);
        AffiliationInformation::createAffiliation([
            'company_id' => $company->company_id,
            'affiliation_code' => $data['affiliation_code'],
            'affiliation_name' => $data['affiliation_name'],
            'display_order' => str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT),
            'organization_type' => $data['organization_type'],
        ]);

        return redirect()->route('affiliation-information.index')->with('success', 'Affiliation created successfully');
    }

    public function show($id)
    {
        return redirect()->route('affiliation-information.edit', $id);
    }

    public function edit($id)
    {
        $affiliation = AffiliationInformation::getAffiliationById($id);
        $companies = CompanyInformation::all();
        return view('affiliation_information.edit', compact('affiliation', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $affiliation = AffiliationInformation::findOrFail($id);
        $data = $request->validate([
            'company_name' => ['required', 'integer'],
            'affiliation_code' => ['required', 'integer', 'unique:affiliation_information,affiliation_code,' . $affiliation->affiliation_code . ',affiliation_code'],
            'affiliation_name' => ['required', 'string', 'max:255'],
            'display_order' => ['required', 'integer', 'between:0,999'],
            'organization_type' => ['required', 'string', 'max:255'],
        ]);

		$company = CompanyInformation::findOrFail($data['company_name']);
		$affiliation->update([
			'company_id' => $company->company_id,
			'affiliation_code' => $data['affiliation_code'],
			'affiliation_name' => $data['affiliation_name'],
			'display_order' => str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT),
			'organization_type' => $data['organization_type'],
		]);

		return redirect()->route('affiliation-information.index')->with('success', 'Affiliation updated successfully');
    }

    public function destroy($id)
    {
        $deleted = AffiliationInformation::deleteAffiliation($id);
        if ($deleted) {
            return redirect()->route('affiliation-information.index')->with('success', 'Affiliation deleted successfully');
        } else {
            return back()->withErrors(['affiliation_code' => 'Affiliation not found.']);
        }
    }

    public function showCourseSettings()
    {
        $affiliations = AffiliationInformation::getAllAffiliations();
        return view('coursesettings', compact('affiliations'));
    }

    public function resetForm()
    {
        return redirect()->route('affiliation-information.create');
    }
}
