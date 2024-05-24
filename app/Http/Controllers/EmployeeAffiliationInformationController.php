<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAffiliationInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CompanyInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use Illuminate\Validation\Rule;

class EmployeeAffiliationInformationController extends Controller
{
    public function index()
    {
        $affiliations = EmployeeAffiliationInformation::all();
        return view('employee_affiliation.index', compact('affiliations'));
    }

    public function create(Request $request)
    {
        // Fetch required data for the form
        $employee_id = $request->input('employee_id');
        $companies = CompanyInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $classification = CourseClassificationInformation::all();

        return view('employee-affiliation-registration', compact('employee_id', 'companies', 'affiliations', 'jobTitles', 'classification'));
    }
    

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'company_id' => 'required|integer',
        'affiliation_code' => 'required|string',
        'job_id' => 'required|integer',
        'application_startdate' => 'required|date',
        'enddate_of_application' => 'required|date',
        'system_administrator_privileges' => 'required|boolean',
        'employee_registration_authority' => 'required|boolean',
        'course_enrollment_privileges' => 'required|boolean',
        'attendance_setting_authority' => 'required|boolean',
        'authority_validity_scope' => 'required|string|max:255',
        'authority_validity_code' => 'required|string|max:255',
    ]);        

    try {
        $validatedData['employee_id'] = $request->input('employee_id');
        EmployeeAffiliationInformation::create($validatedData);
        return redirect()->route('employee-affiliation-information.index')->with('success', 'Affiliation created successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create affiliation. Please try again.');
    }
}


    public function show(string $id)
    {
        try {
            $affiliation = EmployeeAffiliationInformation::findOrFail($id);
            return view('employee_affiliation.show', compact('affiliation'));
        } catch (\Exception $e) {
            return redirect()->route('affiliations.index')->with('error', 'Affiliation not found.');
        }
    }

    public function edit(string $id)
    {
        try {
            $affiliation = EmployeeAffiliationInformation::findOrFail($id);
            return view('employee_affiliation.edit', compact('affiliation'));
        } catch (\Exception $e) {
            return redirect()->route('affiliations.index')->with('error', 'Affiliation not found.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|integer',
            'affiliation_code' => 'required|integer',
            'job_id' => 'required|integer',
            'application_startdate' => 'required|date',
            'enddate_of_application' => 'required|date',
            'system_administrator_privileges' => 'required|boolean',
            'employee_registration_authority' => 'required|boolean',
            'course_enrollment_privileges' => 'required|boolean',
            'attendance_setting_authority' => 'required|boolean',
            'authority_validity_scope' => 'required|string|max:255',
            'authority_validity_code' => 'required|string|max:255',
        ]);
    
        try {
            $affiliation = EmployeeAffiliationInformation::findOrFail($id);
            $affiliation->update($validatedData);
            return redirect()->route('affiliations.index')->with('success', 'Affiliation updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update affiliation. Please try again.');
        }
    }
    
    public function destroy(string $id)
    {
        try {
            EmployeeAffiliationInformation::destroy($id);
            return redirect()->route('affiliations.index')->with('success', 'Affiliation deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete affiliation. Please try again.');
        }
    }
}
