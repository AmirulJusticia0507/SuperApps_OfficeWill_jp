<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\EmployeeAffiliationInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\CourseInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use Illuminate\Validation\Rule;
class EmployeeInformationController extends Controller
{
    public function accessSettings()
    {
        $employeeAffiliations = EmployeeAffiliationInformation::with(['employee', 'affiliation', 'job'])->get();

        return view('employee.access-settings', compact('employeeAffiliations'));
    }

    public function updateAccessSettings(Request $request, string $id)
    {
        $validated = $request->validate([
            'system_administrator_privileges' => ['required', 'boolean'],
            'employee_registration_authority' => ['required', 'boolean'],
            'course_enrollment_privileges' => ['required', 'boolean'],
            'attendance_setting_authority' => ['required', 'boolean'],
            'authority_validity_scope' => ['required', Rule::in(['1', '2', '3'])],
            'authority_validity_code' => ['nullable', 'string', 'max:255'],
        ]);

        EmployeeAffiliationInformation::findOrFail($id)->update($validated);

        return redirect()->route('employee-access-settings.index')->with('success', __('Access settings updated successfully.'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = EmployeeInformation::all();
        $affiliations = AffiliationInformation::all(); // Ambil data affiliations
        $jobs = JobInformation::all(); // Ambil data job titles
        return view('employee.index', compact('employees', 'affiliations', 'jobs')); // Kirim data affiliations dan jobs ke view
    }

	public function employeelist(Request $request)
    {
		$employees = EmployeeInformation::query();

		if ($request->affiliation_code) {
			$employees = $employees->whereHas('employee_affiliation', function ($query) use ($request) {
				$query->where('affiliation_code', $request->affiliation_code);

			});
		}
		if ($request->job) {
			$employees = $employees->whereHas('employee_affiliation.job', function ($query) use ($request) {
				$query->where('job_id', $request->job);

			});
		}
		if ($request->employee_code) {
			$employees = $employees->where('employee_code', $request->employee_code);
		}
		if ($request->fullname) {
			$employees = $employees->where('fullname', $request->fullname);
		}
		$employees = $employees->with('employee_affiliation')->get();
        $affiliations = AffiliationInformation::all();
        $jobs = JobInformation::all();
		$jobTitles = JobInformation::all();
		return view('employeelist', compact('employees', 'affiliations', 'jobs', 'jobTitles'));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $affiliations = AffiliationInformation::all();
        $jobs = JobInformation::all();
        return view('employee.create', compact('affiliations', 'jobs'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:20'],
            'kananame' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:employee_information,email'],
            'contact_phonenumber' => ['nullable', 'string', 'max:13'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sex' => ['nullable', 'string', 'max:10'],
            'dateofbirth' => ['nullable', 'date'],
            'dateofjoining' => ['nullable', 'date'],
            'retirementdate' => ['nullable', 'date', 'after_or_equal:dateofjoining'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['employee_code'] = $this->generateEmployeeCode($validated['fullname']);
        $validated['account_status'] = 'enabled';
        $validated['numberofincorrect_passwords'] = 0;
        EmployeeInformation::create($validated);
        
        return redirect()->route('employee-information.index')->with('success', 'Employee created successfully');
    }

    private function generateEmployeeCode($fullname)
    {
        preg_match_all('/[\p{L}\p{N}]/u', $fullname, $matches);

        return mb_strtoupper(implode('', array_slice($matches[0], 0, 3)));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = EmployeeInformation::find($id);
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = EmployeeInformation::find($id);
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = EmployeeInformation::findOrFail($id);
        $validated = $request->validate([
            'fullname' => ['sometimes', 'required', 'string', 'max:20'],
            'kananame' => ['sometimes', 'nullable', 'string', 'max:20'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('employee_information', 'email')->ignore($employee->employee_id, 'employee_id')],
            'contact_phonenumber' => ['sometimes', 'nullable', 'string', 'max:13'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'sex' => ['sometimes', 'nullable', 'string', 'max:10'],
            'dateofbirth' => ['sometimes', 'nullable', 'date'],
            'dateofjoining' => ['sometimes', 'nullable', 'date'],
            'retirementdate' => ['sometimes', 'nullable', 'date'],
            'remarks' => ['sometimes', 'nullable', 'string', 'max:255'],
            'account_status' => ['sometimes', 'required', Rule::in(['enabled', 'disabled'])],
        ]);
        $employee->update($validated);
        return redirect()->route('employee-information.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EmployeeInformation::findOrFail($id)->delete();
        return redirect()->route('employee-information.index')->with('success', 'Employee deleted successfully');
    }

    public function search(Request $request)
    {
        // Ambil nilai pencarian dari request
        $fullname = $request->input('fullname');
        $employeeCode = $request->input('employee_code');
    
        // Lakukan query berdasarkan kriteria pencarian
        $employees = EmployeeInformation::query();
    
        // Filter berdasarkan fullname jika ada
        if ($fullname) {
            $employees->where('fullname', 'like', '%' . $fullname . '%');
        }
    
        // Filter berdasarkan employee_code jika ada
        if ($employeeCode) {
            $employees->where('employee_code', $employeeCode);
        }
    
        // Eksekusi query dan ambil hasilnya
        $filteredEmployees = $employees->get();
    
        // Kembalikan hasil pencarian ke view
        return view('employee.index', compact('filteredEmployees'));
    }
    

    public function showCourseSettings()
    {
        $employees = EmployeeInformation::all();
        $filteredEmployees = $employees; // Tambahkan baris ini untuk menyediakan data filteredEmployees
        return view('coursesettings', compact('filteredEmployees'));
    }

    public function employeeInquiry()
    {
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobs = JobInformation::all();
        $jobTitles = JobInformation::all();
        $courses = CourseInformation::all();
        $filteredEmployees = EmployeeInformation::all();
        return view('employeeinquiry', compact('affiliations', 'jobs', 'jobTitles', 'filteredEmployees','courses', 'classifications', 'details'));
    }
    
    public function filter(Request $request)
{
    // Ambil nilai pencarian dari request
    $fullname = $request->input('fullname');
    $employeeCode = $request->input('employee_code');

    // Lakukan query berdasarkan kriteria pencarian
    $employees = EmployeeInformation::query();

    // Filter berdasarkan fullname jika ada
    if ($fullname) {
        $employees->where('fullname', 'like', '%' . $fullname . '%');
    }

    // Filter berdasarkan employee_code jika ada
    if ($employeeCode) {
        $employees->where('employee_code', $employeeCode);
    }

    // Eksekusi query dan ambil hasilnya
    $filteredEmployees = $employees->get();

    // Kembalikan hasil pencarian ke view
    return view('coursesettings', compact('filteredEmployees'));
}

}
