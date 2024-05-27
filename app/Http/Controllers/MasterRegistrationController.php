<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttributeSettingInformation;
use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\EmployeeAffiliationInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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
		$attribute = EmployeeAttributeSettingInformation::where('company_id', 1)->latest()->first();
		return view('member-registration', compact('affiliations', 'jobTitles', 'attribute'));
	}

	public function store(Request $request)
	{
		// dd($request->all());
		// // Validasi data dari formulir
		// $validatedData = $request->validate([
		// 	// Validasi untuk field-field dari employee_information
		// 	'fullname' => 'required|string|max:255',
		// 	'kananame' => 'nullable|string|max:255',
		// 	'email' => 'required|string|email|max:255|unique:employee_information',
		// 	'contact_phonenumber' => 'nullable|string|max:20',
		// 	'employee_code' => 'required|string|max:50|unique:employee_information',
		// 	'sex' => 'nullable|string|max:10',
		// 	'dateofbirth' => 'nullable|date',
		// 	'dateofjoining' => 'nullable|date',
		// 	'retirementdate' => 'nullable|date',
		// 	'remarks' => 'nullable|string|max:255',
		// 	'password' => 'required|string|max:255',
		// 	'account_status' => 'required|string|max:20',
		// 	'password_expiration' => 'nullable|date',
		// 	'numberofincorrect_passwords' => 'required|integer',
		// 	'account_lock_datetime' => 'nullable|date',
		// 	'employee_attribute01' => 'nullable|string|max:255',
		// 	'employee_attribute02' => 'nullable|string|max:255',
		// 	'employee_attribute03' => 'nullable|string|max:255',
		// 	'employee_attribute04' => 'nullable|string|max:255',
		// 	'employee_attribute05' => 'nullable|string|max:255',
		// 	// 'company_id' => 'required',

		// 	// Validasi untuk field-field dari employee_affiliation_information
		// 	'affiliation_code' => 'required',
		// 	'job_title' => 'required',
		// 	'application_startdate' => 'required|date',
		// 	// 'enddate_of_application' => 'required|date',
		// 	'system_administrator_privileges' => 'required|boolean',
		// 	'employee_registration_authority' => 'required|boolean',
		// 	'course_enrollment_privileges' => 'required|boolean',
		// 	'attendance_setting_authority' => 'required|boolean',
		// 	'authority_validity_scope' => 'required|string|max:255',
		// 	'authority_validity_code' => 'required|string|max:255',
		// ]);

		$affiliation = AffiliationInformation::where('affiliation_code', str_pad($request->affiliation, 3, '0', STR_PAD_LEFT))->first();

		// Membuat entri baru dalam tabel employee_information
		$employeeInformation = EmployeeInformation::create([
			'company_id' => $affiliation->company_id,
			'fullname' => $request->fullname,
			'kananame' => $request->kananame,
			'email' => $request->email,
			'contact_phonenumber' => $request->contact_phonenumber,
			'employee_code' => $request->employee_code,
			'sex' => $request->sex,
			'dateofbirth' => $request->dateofbirth,
			'dateofjoining' => $request->dateofjoining,
			'retirementdate' => $request->retirementdate,
			'remarks' => $request->remarks,
			'password' => Hash::make($request->password),
			'account_status' => $request->account_status,
			'password_expiration' => $request->password_expiration,
			'numberofincorrect_passwords' => $request->numberofincorrect_passwords,
			'account_lock_datetime' => $request->account_lock_datetime,
			'employee_attribute01' => $request->employee_attribute01,
			'employee_attribute02' => $request->employee_attribute02,
			'employee_attribute03' => $request->employee_attribute03,
			'employee_attribute04' => $request->employee_attribute04,
			'employee_attribute05' => $request->employee_attribute05,
		]);


		// Membuat entri baru dalam tabel employee_affiliation_information
		$affiliationInformation = EmployeeAffiliationInformation::create([
			'company_id' => $affiliation->company_id,
			'employee_id' => $employeeInformation->employee_id,
			'affiliation_code' => $affiliation->affiliation_code,
			'job_id' => $request->job,
			'application_startdate' => $request->application_startdate,
			'system_administrator_privileges' => $request->system_administrator_privileges,
			'employee_registration_authority' => $request->employee_registration_authority,
			'course_enrollment_privileges' => $request->course_enrollment_privileges,
			'attendance_setting_authority' => $request->attendance_setting_authority,
			'authority_validity_scope' => $request->authority_validity_scope,
			'authority_validity_code' => $request->authority_validity_code,
		]);

		// Redirect dengan pesan sukses jika berhasil disimpan
		return redirect()->route('member-registration.index')->with('success', 'Member registered successfully!');
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
			'email' => 'required|string|email|max:255|unique:employee_information,email,' . $id,
			'contact_phone_number' => 'nullable|string|max:20',
			'employee_code' => 'required|string|max:50|unique:employee_information,employee_code,' . $id,
			'sex' => 'nullable|string|max:10',
			'dateofbirth' => 'nullable|date',
			'dateofjoining' => 'nullable|date',
			'retirementdate' => 'nullable|date',
			'remarks' => 'nullable|string|max:255',
			'password' => 'required|string|max:255',
			'account_status' => 'required|string|max:20',
			'password_expiration' => 'nullable|date',
			'numberofincorrect_passwords' => 'required|integer',
			'account_lock_datetime' => 'nullable|date',
			'employee_attribute01' => 'nullable|string|max:255',
			'employee_attribute02' => 'nullable|string|max:255',
			'employee_attribute03' => 'nullable|string|max:255',
			'employee_attribute04' => 'nullable|string|max:255',
			'employee_attribute05' => 'nullable|string|max:255',
			'company_id' => 'required',
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
