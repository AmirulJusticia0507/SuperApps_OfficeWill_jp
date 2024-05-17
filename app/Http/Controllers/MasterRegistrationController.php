<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\EmployeeAffiliationInformation;

class MasterRegistrationController extends Controller
{
    public function index()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        return view('member-registration', compact('affiliations', 'jobTitles'));
    }

    public function create()
    {
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        return view('member-registration', compact('affiliations', 'jobTitles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'kananame' => 'nullable|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:employee_information',
            'contact_phonenumber' => 'nullable|string|max:20',
            'employee_code' => 'required|string|max:50|unique:employee_information',
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
            'employee_attribute01' => 'nullable|string|max:255',
            'employee_attribute02' => 'nullable|string|max:255',
            'employee_attribute03' => 'nullable|string|max:255',
            'employee_attribute04' => 'nullable|string|max:255',
            'employee_attribute05' => 'nullable|string|max:255',
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

        // Create employee information
        $employeeInformation = EmployeeInformation::create($validatedData);

        // Create employee affiliation information
        $affiliationInformation = EmployeeAffiliationInformation::create([
            'employee_id' => $employeeInformation->id,
            'company_id' => $validatedData['company_id'],
            'affiliation_code' => $validatedData['affiliation_code'],
            'job_id' => $validatedData['job_id'],
            'application_startdate' => $validatedData['application_startdate'],
            'enddate_of_application' => $validatedData['enddate_of_application'],
            'system_administrator_privileges' => $validatedData['system_administrator_privileges'],
            'employee_registration_authority' => $validatedData['employee_registration_authority'],
            'course_enrollment_privileges' => $validatedData['course_enrollment_privileges'],
            'attendance_setting_authority' => $validatedData['attendance_setting_authority'],
            'authority_validity_scope' => $validatedData['authority_validity_scope'],
            'authority_validity_code' => $validatedData['authority_validity_code'],
        ]);

        return redirect()->route('member-registration')->with('success', 'Member registered successfully!');
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
            'email_address' => 'required|string|email|max:255|unique:employee_information,email_address,'.$id,
            'contact_phone_number' => 'nullable|string|max:20',
            'employee_code' => 'required|string|max:50|unique:employee_information,employee_code,'.$id,
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
            'employee_attribute01' => 'nullable|string|max:255',
            'employee_attribute02' => 'nullable|string|max:255',
            'employee_attribute03' => 'nullable|string|max:255',
            'employee_attribute04' => 'nullable|string|max:255',
            'employee_attribute05' => 'nullable|string|max:255',
            'company_id' => 'required|integer',
        ]);

        $member = EmployeeInformation::findOrFail($id);
        
        $member->update($validatedData);

        return redirect()->route('member-registration')->with('success', 'Member updated successfully!');
    }

    public function destroy($id)
    {
        $member = EmployeeInformation::findOrFail($id);
        $member->delete();
        return redirect()->route('dashboard')->with('success', 'Member deleted successfully!');
    }
}
