<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseInformation;
use App\Models\CourseMaterialInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;

class CourseInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = CourseInformation::all();
        $classifications = CourseClassificationInformation::all();
        $details = CourseClassificationDetailInformation::all();
        return view('course_information.index', compact('courses', 'classifications', 'details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|numeric', // ID perusahaan wajib diisi dan harus berupa angka
            'Course_classification_id' => 'required|numeric', // ID klasifikasi kursus wajib diisi dan harus berupa angka
            'coursename' => 'required|string|max:255', // Nama kursus wajib diisi, harus berupa string, dan maksimal 255 karakter
            'coursename_kana' => 'required|string|max:255', // Nama kursus (Kana) wajib diisi, harus berupa string, dan maksimal 255 karakter
            'course_description' => 'nullable|string', // Deskripsi kursus opsional, harus berupa string
            'possible_retake_course_deadline' => 'nullable|date', // Batas waktu pengulangan kursus opsional, harus berupa format tanggal
            'remarks' => 'nullable|string', // Catatan kursus opsional, harus berupa string
            'todo_type' => 'nullable|string|max:255', // Tipe tugas kursus opsional, harus berupa string dan maksimal 255 karakter
            'todo_description' => 'nullable|string', // Deskripsi tugas kursus opsional, harus berupa string
            'repeated_retest' => 'nullable|boolean', // Pengulangan tes kursus opsional, harus berupa boolean (true/false)
            'test_passed_score' => 'nullable|numeric', // Skor lulus tes kursus opsional, harus berupa angka
            'course_attributes_01' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_02' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_03' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_04' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_05' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
        ]);

        // Simpan data ke tabel course_information
        $course = CourseInformation::create($request->only([
            'company_id',
            'Course_classification_id',
            'coursename',
            'coursename_kana',
            'course_description',
            'possible_retake_course_deadline',
            'remarks',
            'todo_type',
            'todo_description',
            'repeated_retest',
            'test_passed_score',
            'course_attributes_01',
            'course_attributes_02',
            'course_attributes_03',
            'course_attributes_04',
            'course_attributes_05',
            // Masukkan field lain yang sesuai dengan tabel course_information
        ]));

        // Simpan data ke tabel course_material_information
        CourseMaterialInformation::create([
            'course_id' => $course->id, // Ambil ID course yang baru dibuat
            'company_id' => $request->input('company_id'),
            'teaching_material_name' => $request->input('teaching_material_name'),
            'material_type' => $request->input('material_type'),
            'youtube_video_url' => $request->input('youtube_video_url'),
            'book_file_path' => $request->input('book_file_path'),
            // Masukkan field lain yang sesuai dengan tabel course_material_information
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('materials.index')->with('success', 'Course created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = CourseInformation::find($id);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'company_id' => 'required|numeric', // ID perusahaan wajib diisi dan harus berupa angka
            'Course_classification_id' => 'required|numeric', // ID klasifikasi kursus wajib diisi dan harus berupa angka
            'coursename' => 'required|string|max:255', // Nama kursus wajib diisi, harus berupa string, dan maksimal 255 karakter
            'coursename_kana' => 'required|string|max:255', // Nama kursus (Kana) wajib diisi, harus berupa string, dan maksimal 255 karakter
            'course_description' => 'nullable|string', // Deskripsi kursus opsional, harus berupa string
            'possible_retake_course_deadline' => 'nullable|date', // Batas waktu pengulangan kursus opsional, harus berupa format tanggal
            'remarks' => 'nullable|string', // Catatan kursus opsional, harus berupa string
            'todo_type' => 'nullable|string|max:255', // Tipe tugas kursus opsional, harus berupa string dan maksimal 255 karakter
            'todo_description' => 'nullable|string', // Deskripsi tugas kursus opsional, harus berupa string
            'repeated_retest' => 'nullable|boolean', // Pengulangan tes kursus opsional, harus berupa boolean (true/false)
            'test_passed_score' => 'nullable|numeric', // Skor lulus tes kursus opsional, harus berupa angka
            'course_attributes_01' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_02' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_03' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_04' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
            'course_attributes_05' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
        ]);

        $course = CourseInformation::find($id);
        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseInformation::destroy($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }

    /**
     * Show the Course Registration page.
     */
    public function courseRegistration()
    {
        return view('course-registration');
    }
}
