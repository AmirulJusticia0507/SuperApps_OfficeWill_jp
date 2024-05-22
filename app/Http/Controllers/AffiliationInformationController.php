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
        $request->validate([
            'company_name' => 'required',
            'affiliation_code' => 'required',
            'affiliation_name' => 'required',
            'display_order' => 'required',
            'organization_type' => 'required',
        ]);

        $company = CompanyInformation::find($request->input('company_name'));

        if ($company) {
            $affiliationData = [
                'company_id' => $company->company_id,
                'affiliation_code' => $request->input('affiliation_code'),
                'affiliation_name' => $request->input('affiliation_name'),
                'display_order' => $request->input('display_order'),
                'organization_type' => $request->input('organization_type'),
            ];

            AffiliationInformation::createAffiliation($affiliationData);

            return redirect()->route('affiliation-information.index')->with('success', 'Affiliation created successfully');
        } else {
            return back()->withErrors(['company_name' => 'Company not found.'])->withInput();
        }
    }

    public function show($id)
    {
        $affiliation = AffiliationInformation::getAffiliationById($id);
        return view('affiliation_information.show', compact('affiliation'));
    }

    public function edit($id)
    {
        $affiliation = AffiliationInformation::getAffiliationById($id);
        $companies = CompanyInformation::all();
        return view('affiliation_information.edit', compact('affiliation', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
            'affiliation_code' => 'required',
            'affiliation_name' => 'required',
            'display_order' => 'required',
            'organization_type' => 'required',
        ]);

        $affiliationData = [
            'company_id' => $request->input('company_name'),
            'affiliation_code' => $request->input('affiliation_code'),
            'affiliation_name' => $request->input('affiliation_name'),
            'display_order' => $request->input('display_order'),
            'organization_type' => $request->input('organization_type'),
        ];

        $affiliation = AffiliationInformation::updateAffiliation($id, $affiliationData);

        if ($affiliation) {
            return redirect()->route('affiliation-information.index')->with('success', 'Affiliation updated successfully');
        } else {
            return back()->withErrors(['affiliation_code' => 'Affiliation not found.'])->withInput();
        }
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
