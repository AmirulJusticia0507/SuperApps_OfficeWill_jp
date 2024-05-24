<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\CompanyInformation;
use App\Models\CourseClassificationInformation;
use App\Models\EmployeeAffiliationInformation;
use Illuminate\Validation\Rule;

class MasterRegistrationController extends Controller
{
    public function create()
    {
        // Mendapatkan data yang diperlukan untuk formulir
        $companies = CompanyInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $classification = CourseClassificationInformation::all();
        $member = null;
        return view('member-registration', compact('companies', 'affiliations', 'jobTitles', 'classification', 'member'));
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validatedEmployeeData = $request->validate([
            // Validasi data untuk tabel EmployeeInformation
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
        
        $validatedAffiliationData = $request->validate([
            // Validasi data untuk tabel EmployeeAffiliationInformation
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
            // Simpan data ke tabel EmployeeInformation
            $employeeInformation = EmployeeInformation::create($validatedEmployeeData);
            
            // Tambahkan employee_id ke data affiliations
            $validatedAffiliationData['employee_id'] = $employeeInformation->employee_id;

            // Simpan data ke tabel EmployeeAffiliationInformation
            EmployeeAffiliationInformation::create($validatedAffiliationData);

            return redirect()->route('employee-affiliation-information.index')->with('success', 'Employee and affiliation created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create employee and affiliation. Please try again.');
        }
    }
    
    public function edit($id)
    {
        $companies = CompanyInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobTitles = JobInformation::all();
        $classification = CourseClassificationInformation::all();
        $member = EmployeeInformation::findOrFail($id);
        
        return view('member-registration', compact('companies', 'affiliations', 'jobTitles', 'classification', 'member'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedEmployeeData = $request->validate([
            // Validasi data untuk tabel EmployeeInformation
            'company_id' => 'required|integer',
            'fullname' => 'required|string|max:255',
            'kananame' => 'nullable|string|max:255',
            'email_address' => ['required', 'string', 'email', 'max:255', Rule::unique('employee_information')->ignore($id, 'employee_id')],
            'contact_phonenumber' => 'nullable|string|max:20',
            'employee_code' => ['required', 'string', 'max:50', Rule::unique('employee_information')->ignore($id, 'employee_id')],
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

        $validatedAffiliationData = $request->validate([
            // Validasi data untuk tabel EmployeeAffiliationInformation
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
            // Perbarui data ke tabel EmployeeInformation
            $member = EmployeeInformation::findOrFail($id);
            $member->update($validatedEmployeeData);
            
            // Simpan atau perbarui Informasi Afiliasi Karyawan
            $employeeAffiliation = EmployeeAffiliationInformation::where('employee_id', $id)->first();
            if (!$employeeAffiliation) {
                $employeeAffiliation = new EmployeeAffiliationInformation();
                $employeeAffiliation->employee_id = $id;
            }
            $employeeAffiliation->update($validatedAffiliationData);
    
            // Redirect kembali dengan pesan sukses
            return redirect()->route('member-registration.create')->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update member. Please try again.');
        }
    }
}