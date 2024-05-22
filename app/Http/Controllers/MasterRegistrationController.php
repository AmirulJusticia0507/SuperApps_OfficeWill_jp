<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\EmployeeAffiliationInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MasterRegistrationController extends Controller
{
    public function index()
    {
        $classification = CourseClassificationInformation::all();
        $companies = CompanyInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        return view('member-registration', compact('affiliations', 'classification', 'jobTitles','companies'));
    }

    public function create()
    {
        // Fetch required data for the form
        $employee_id = time(); // Generate a unique employee ID
        $companies = CompanyInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $classification = CourseClassificationInformation::all();
    
        return view('member-registration', compact('employee_id', 'companies', 'affiliations', 'jobTitles', 'classification'));
    }
    
    public function store(Request $request)
    {
        // Validate and store the employee information
        $validatedData = $request->validate([
            'company_id' => 'required|integer',
            'fullname' => 'required|string|max:255',
            'kananame' => 'nullable|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:employee_information,email_address',
            'contact_phonenumber' => 'nullable|string|max:20',
            'employee_code' => 'required|string|max:50|unique:employee_information,employee_code',
            'sex' => 'required|string|max:10',
            'dateofbirth' => 'required|date',
            'dateofjoining' => 'required|date',
            'retirementdate' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'encrypted_password' => 'required|string|max:255',
            'account_status' => 'required|string|max:20',
            'password_expiration' => 'nullable|date',
            'numberofincorrect_passwords' => 'required|integer',
            'account_lock_datetime' => 'nullable|date',
        ]);
    
        // Dump the request data to the console
        dd($request->all());
    
        // Create employee information
        $employeeInformation = EmployeeInformation::create($validatedData);
    
        // Redirect back with the employee_id to fill in the second form
        return redirect()->route('employee-affiliation-information.create', ['employee_id' => $employeeInformation->employee_id])
                     ->with('success', 'Employee information saved successfully.');
    }
    
    public function edit($id)
    {
        $member = EmployeeInformation::findOrFail($id);
        return view('edit-member', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'kananame' => 'nullable|string|max:255',
            'email_address' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('employee_information')->ignore($id),
            ],
            'contact_phonenumber' => 'nullable|string|max:20',
            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employee_information')->ignore($id),
            ],
            'sex' => 'nullable|string|max:10',
            'dateofbirth' => 'nullable|date',
            'dateofjoining' => 'nullable|date',
            'retirementdate' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'encrypted_password' => 'required|string|max:255',
            'account_status' => 'required|string|max:20',
            'password_expiration' => 'nullable|date',
            'numberofincorrect_passwords' => 'required|integer',
            'account_lock_datetime' => 'nullable|date',
            'company_id' => 'required|integer',
        ]);

        $member = EmployeeInformation::findOrFail($id);
        $member->update($validatedData);

        return redirect()->route('member-registration.index')->with('success', 'Member updated successfully!');
    }

    public function destroy($id)
    {
        $member = EmployeeInformation::findOrFail($id);
        $member->delete();
        return redirect()->route('dashboard')->with('success', 'Member deleted successfully!');
    }
}
