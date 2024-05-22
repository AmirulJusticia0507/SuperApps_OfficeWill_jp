<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseInformation;
use App\Models\CompanyInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseMaterialInformation;
use Illuminate\Http\JsonResponse;

class CourseInformationController extends Controller
{
    public function index()
    {
        $companies = CompanyInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('course_information.index', compact('companies', 'classifications', 'details'));
    }
    
    public function store(Request $request)
    {
        try {
        // Validasi data dari formulir pertama (Course Information)
        $courseValidationRules = [
            'company_id' => 'required|exists:company_information,id',
            'course_classification_id' => 'required|exists:course_classification_information,course_classification_id',
            'course_classification_details_id' => 'required|exists:course_classification_detail_information,course_classification_details_id',
            'coursename' => 'required|string|max:255',
            'coursename_kana' => 'nullable|string|max:255',
            'course_description' => 'required|string',
            'possible_retake_course_deadline' => 'required|string',
            'remarks' => 'nullable|string',
            'todo_type' => 'required|string',
            'todo_description' => 'required|string',
            'repeated_retest' => 'required|string',
            'test_passed_score' => 'nullable|string', // Sesuaikan dengan aturan validasi yang sesuai
            'course_attributes_01' => 'nullable|string', // Sesuaikan dengan aturan validasi yang sesuai
            'course_attributes_02' => 'nullable|string', // Sesuaikan dengan aturan validasi yang sesuai
            'course_attributes_03' => 'nullable|string', // Sesuaikan dengan aturan validasi yang sesuai
            'course_attributes_04' => 'nullable|string', // Sesuaikan dengan aturan validasi yang sesuai
            'course_attributes_05' => 'nullable|string', // Sesuaikan dengan aturan validasi yang sesuai
        ];
    
        $validatedCourseData = $request->validate($courseValidationRules);
    
        // Simpan data Course Information
        $course = new CourseInformation();
        $course->fill($validatedCourseData);
        $course->save();
    
        // Validasi data dari formulir kedua (Course Material Information)
        $materialValidationRules = [
            'company_id' => 'required|exists:company_information,id',
            'teaching_material_name' => 'required|string',
            'material_type' => 'required|string',
        ];
    
        $validatedMaterialData = $request->validate($materialValidationRules);
    
        // Handle file upload jika ada
        if ($request->hasFile('bookfile')) {
            $bookFilePath = $request->file('bookfile')->store('books', 'public');
            $validatedMaterialData['book_file_path'] = $bookFilePath;
        }
    
        // Jika menggunakan relasi antara Course Information dan Course Material Information,
        // maka pastikan Anda menyimpan material dengan mengaitkannya ke course yang sesuai.
        $courseMaterial = new CourseMaterialInformation();
        $courseMaterial->fill($validatedMaterialData);
        $courseMaterial->company_id = $validatedMaterialData['company_id'];
        $courseMaterial->course_id = $course->course_id; // Mengaitkan Course Material dengan Course Information yang baru saja disimpan
        $courseMaterial->save();
    
        // Jika semua data berhasil disimpan, arahkan pengguna ke halaman yang sesuai
        return redirect()->route('course-registration.index')->with('success', 'Data berhasil disimpan');
    } catch (\Throwable $th) {
        // Tangani exception jika terjadi kesalahan dalam validasi atau penyimpanan
        return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan dalam menyimpan data. Silakan coba lagi.']);
        }
    }
    
}
