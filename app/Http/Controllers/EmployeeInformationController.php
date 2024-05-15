<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\AffiliationInformation;
use App\Models\JobInformation;
use App\Models\CourseInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
class EmployeeInformationController extends Controller
{
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
    
    public function employeelist()
    {
        $employees = EmployeeInformation::all();
        $affiliations = AffiliationInformation::all();
        $jobs = JobInformation::all();
        $filteredEmployees = $employees; // Menggunakan data $employees sebagai $filteredEmployees
        return view('employeelist', compact('filteredEmployees', 'affiliations', 'jobs'));
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
        // Ambil nama lengkap dari input
        $fullname = $request->input('fullname');
        
        // Hasilkan kode karyawan dari nama lengkap
        $employeeCode = $this->generateEmployeeCode($fullname);
    
        // Tambahkan kode karyawan ke dalam request sebelum menyimpan data
        $request->merge(['employee_code' => $employeeCode]);
    
        // Simpan data karyawan ke dalam database
        EmployeeInformation::create($request->all());
        
        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    private function generateEmployeeCode($fullname)
    {
        // Misalnya, menggunakan inisial dari setiap kata dalam nama lengkap
        $initials = implode('', array_map('ucfirst', array_map('substr', explode(' ', $fullname), array_fill(0, count(explode(' ', $fullname)), 0, 1))));
        
        // Anda dapat menambahkan logika lain sesuai kebutuhan
        return $initials;
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
        $employee = EmployeeInformation::find($id);
        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EmployeeInformation::destroy($id);
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
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
    
}
