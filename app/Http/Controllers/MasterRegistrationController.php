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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MasterRegistrationController extends Controller
{
	public function index()
	{
		$affiliations = AffiliationInformation::all();
		$jobTitles = JobInformation::all();
		$employeeCodes = DB::table('employee_information')->whereNotNull('employee_code')->pluck('employee_code');
		return view('member-registration', compact('affiliations', 'jobTitles', 'employeeCodes'));
	}

	public function create()
	{
		$affiliations = AffiliationInformation::all();
		$jobTitles = JobInformation::all();
		$attribute = EmployeeAttributeSettingInformation::where('company_id', 1)->latest()->first();
		$employeeCodes = DB::table('employee_information')->whereNotNull('employee_code')->pluck('employee_code');
		return view('member-registration', compact('affiliations', 'jobTitles', 'attribute', 'employeeCodes'));
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'fullname' => ['required', 'string', 'max:20'],
			'kananame' => ['nullable', 'string', 'max:20'],
			'email' => ['required', 'email', 'max:255', 'unique:employee_information,email'],
			'email_confirmation' => ['required', 'same:email'],
			'contact_phonenumber' => ['nullable', 'string', 'max:13'],
			'employee_code' => ['required', 'string', 'max:10', 'unique:employee_information,employee_code'],
			'sex' => ['nullable', Rule::in(['male', 'female', 'other'])],
			'dateofbirth' => ['nullable', 'date'],
			'dateofjoining' => ['nullable', 'date'],
			'retirementdate' => ['nullable', 'date', 'after_or_equal:dateofjoining'],
			'remarks' => ['nullable', 'string', 'max:255'],
			'password' => ['required', 'string', 'min:8'],
			'account_status' => ['required', Rule::in(['enabled', 'disabled'])],
			'password_expiration' => ['nullable', 'date'],
			'affiliation' => ['required', 'integer'],
			'job' => ['required', 'integer'],
			'application_startdate' => ['required', 'date'],
			'system_administrator_privileges' => ['required', 'boolean'],
			'employee_registration_authority' => ['required', 'boolean'],
			'course_enrollment_privileges' => ['required', 'boolean'],
			'attendance_setting_authority' => ['required', 'boolean'],
			'authority_validity_scope' => ['required', Rule::in(['1', '2', '3'])],
			'authority_validity_code' => ['required', 'string', 'max:255'],
			'employee_attribute01' => ['nullable', 'string', 'max:255'],
			'employee_attribute02' => ['nullable', 'string', 'max:255'],
			'employee_attribute03' => ['nullable', 'string', 'max:255'],
			'employee_attribute04' => ['nullable', 'string', 'max:255'],
			'employee_attribute05' => ['nullable', 'string', 'max:255'],
		]);

		$affiliation = AffiliationInformation::findOrFail(str_pad((string) $data['affiliation'], 3, '0', STR_PAD_LEFT));
		$job = JobInformation::findOrFail($data['job']);
		abort_unless((int) $job->company_id === 0 || (int) $job->company_id === (int) $affiliation->company_id, 422);

		DB::transaction(function () use ($data, $affiliation) {
			$employeeInformation = EmployeeInformation::create([
				'company_id' => $affiliation->company_id,
				'fullname' => $data['fullname'],
				'kananame' => $data['kananame'] ?? null,
				'email' => $data['email'],
				'contact_phonenumber' => $data['contact_phonenumber'] ?? null,
				'employee_code' => $data['employee_code'],
				'sex' => $data['sex'] ?? null,
				'dateofbirth' => $data['dateofbirth'] ?? null,
				'dateofjoining' => $data['dateofjoining'] ?? null,
				'retirementdate' => $data['retirementdate'] ?? null,
				'remarks' => $data['remarks'] ?? null,
				'password' => Hash::make($data['password']),
				'account_status' => $data['account_status'],
				'password_expiration' => $data['password_expiration'] ?? null,
				'numberofincorrect_passwords' => 0,
				'account_lock_datetime' => null,
				'employee_attribute01' => $data['employee_attribute01'] ?? null,
				'employee_attribute02' => $data['employee_attribute02'] ?? null,
				'employee_attribute03' => $data['employee_attribute03'] ?? null,
				'employee_attribute04' => $data['employee_attribute04'] ?? null,
				'employee_attribute05' => $data['employee_attribute05'] ?? null,
			]);

			EmployeeAffiliationInformation::create([
				'company_id' => $affiliation->company_id,
				'employee_id' => $employeeInformation->employee_id,
				'affiliation_code' => $affiliation->affiliation_code,
				'job_id' => $data['job'],
				'application_startdate' => $data['application_startdate'],
				'system_administrator_privileges' => $data['system_administrator_privileges'],
				'employee_registration_authority' => $data['employee_registration_authority'],
				'course_enrollment_privileges' => $data['course_enrollment_privileges'],
				'attendance_setting_authority' => $data['attendance_setting_authority'],
				'authority_validity_scope' => $data['authority_validity_scope'],
				'authority_validity_code' => $data['authority_validity_code'],
			]);
		});

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
		$member = EmployeeInformation::findOrFail($id);
		$data = $request->validate([
			'fullname' => ['required', 'string', 'max:20'],
			'kananame' => ['nullable', 'string', 'max:20'],
			'email' => ['required', 'email', 'max:255', Rule::unique('employee_information', 'email')->ignore($member->employee_id, 'employee_id')],
			'contact_phonenumber' => ['nullable', 'string', 'max:13'],
			'employee_code' => ['required', 'string', 'max:10', Rule::unique('employee_information', 'employee_code')->ignore($member->employee_id, 'employee_id')],
			'sex' => ['nullable', Rule::in(['male', 'female', 'other'])],
			'dateofbirth' => ['nullable', 'date'],
			'dateofjoining' => ['nullable', 'date'],
			'retirementdate' => ['nullable', 'date', 'after_or_equal:dateofjoining'],
			'remarks' => ['nullable', 'string', 'max:255'],
			'password' => ['sometimes', 'nullable', 'string', 'min:8'],
			'account_status' => ['required', Rule::in(['enabled', 'disabled'])],
			'password_expiration' => ['nullable', 'date'],
			'employee_attribute01' => ['nullable', 'string', 'max:255'],
			'employee_attribute02' => ['nullable', 'string', 'max:255'],
			'employee_attribute03' => ['nullable', 'string', 'max:255'],
			'employee_attribute04' => ['nullable', 'string', 'max:255'],
			'employee_attribute05' => ['nullable', 'string', 'max:255'],
		]);

		if (empty($data['password'])) {
			unset($data['password']);
		}
		$member->update($data);

		return redirect()->route('member-registration.index')->with('success', 'Member updated successfully!');
	}

	public function destroy($id)
	{
		$member = EmployeeInformation::findOrFail($id);
		$member->delete();
		return redirect()->route('dashboard')->with('success', 'Member deleted successfully!');
	}
}
