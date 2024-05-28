<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use App\Models\CourseAttributeSettingInformation;
use App\Models\CourseTodoItemInformation;
use App\Models\CourseTodoItemsChoiceInformation;
use Illuminate\Http\Request;
use App\Models\CourseInformation;
use App\Models\CourseMaterialInformation;
use App\Models\CourseClassificationInformation;
use App\Models\CourseClassificationDetailInformation;
use Illuminate\Support\Facades\DB;

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
		// dd($request->all());
		// $request->validate([
		//     'course_classification_id' => 'required|numeric', // ID klasifikasi kursus wajib diisi dan harus berupa angka
		//     'coursename' => 'required|string|max:255', // Nama kursus wajib diisi, harus berupa string, dan maksimal 255 karakter
		//     'coursename_kana' => 'required|string|max:255', // Nama kursus (Kana) wajib diisi, harus berupa string, dan maksimal 255 karakter
		//     'course_description' => 'nullable|string', // Deskripsi kursus opsional, harus berupa string
		//     'possible_retake_course_deadline' => 'nullable|date', // Batas waktu pengulangan kursus opsional, harus berupa format tanggal
		//     'remarks' => 'nullable|string', // Catatan kursus opsional, harus berupa string
		//     'todo_type' => 'nullable|string|max:255', // Tipe tugas kursus opsional, harus berupa string dan maksimal 255 karakter
		//     'todo_description' => 'nullable|string', // Deskripsi tugas kursus opsional, harus berupa string
		//     'repeated_retest' => 'nullable|boolean', // Pengulangan tes kursus opsional, harus berupa boolean (true/false)
		//     'test_passed_score' => 'nullable|numeric', // Skor lulus tes kursus opsional, harus berupa angka
		//     'course_attributes_01' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		//     'course_attributes_02' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		//     'course_attributes_03' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		//     'course_attributes_04' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		//     'course_attributes_05' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		// ]);

		try {
			DB::beginTransaction();
			$course_class_info = CourseClassificationInformation::where('course_classification_id', $request->course_classification_id)->first();

			$course = CourseInformation::create([
				'company_id' => $course_class_info->company_id,
				'course_classification_id' => $course_class_info->course_classification_id,
				'course_classification_details_id' => $request->course_classification_details_id,
				'coursename' => $request->coursename,
				'coursename_kana' => $request->coursename_kana,
				'course_description' => $request->course_description,
				'possible_retake_course_deadline' => $request->possible_retake_course_deadline,
				'remarks' => $request->remarks,
				'todo_type' => $request->todo_type,
				'todo_description' => $request->todo_description,
				'repeated_retest' => $request->repeated_retest,
				'test_passed_score' => $request->test_passed_score,
				'course_attributes_01' => $request->course_attributes_01,
				'course_attributes_02' => $request->course_attributes_02,
				'course_attributes_03' => $request->course_attributes_03,
				'course_attributes_04' => $request->course_attributes_04,
				'course_attributes_05' => $request->course_attributes_05,
			]);

			$display_order = 1;
			foreach ($request->teaching_material as $teaching_material) {
				$company_info = CompanyInformation::where('company_id', $course_class_info->company_id)->first();
				$bookfile = $request->hasFile('bookfile') ? $request->file('bookfile')->store('public/' . str_replace('/storage/', '', $company_info->teaching_material_storage_file_path)) : null;
				CourseMaterialInformation::create([
					'course_id' => $course->course_id, // Ambil ID course yang baru dibuat
					'company_id' => $course_class_info->company_id,
					'display_order' => $display_order,
					'teaching_material_name' => $teaching_material['teaching_material_name'],
					'material_type' => $teaching_material['material_type'],
					'youtube_video_url' => $teaching_material['youtube_video_url'],
					'book_file_path' => $bookfile,
				]);
				$display_order++;
			}

			$todo_order = 1;
			foreach ($request->todo as $todo) {
				$todo_item = CourseTodoItemInformation::create([
					'course_id' => $course->course_id,
					'company_id' => $course_class_info->company_id,
					'display_order' => $todo_order,
					'question' => $todo['question'],
					'answer_type' => $todo['answer_type'],
					'required_settings' => $todo['answer_input'] ?? null,
					'test_explained' => $request->todo_type == "2" && $todo['answer_type'] != "1" ? $todo['explanation'] : null,
				]);
				$option_order = 1;

				foreach ($todo->option ?? [] as $option) {
					CourseTodoItemsChoiceInformation::create([
						'todo_items_id' => $todo_item->todo_item_id,
						'course_id' => $course->course_id,
						'company_id' => $course_class_info->company_id,
						'display_order' => $display_order,
						'choices' => $option,
						'test_choice_correct_answer' => $todo['correct_answer'],
					]);
					$option_order++;
				}


				$todo_order++;
			}

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			dd($th);
		}



		// Redirect dengan pesan sukses
		return redirect()->route('course-list')->with('success', 'Course created successfully');
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
		// $request->validate([
		// 	'company_id' => 'required|numeric', // ID perusahaan wajib diisi dan harus berupa angka
		// 	'course_classification_id' => 'required|numeric', // ID klasifikasi kursus wajib diisi dan harus berupa angka
		// 	'coursename' => 'required|string|max:255', // Nama kursus wajib diisi, harus berupa string, dan maksimal 255 karakter
		// 	'coursename_kana' => 'required|string|max:255', // Nama kursus (Kana) wajib diisi, harus berupa string, dan maksimal 255 karakter
		// 	'course_description' => 'nullable|string', // Deskripsi kursus opsional, harus berupa string
		// 	'possible_retake_course_deadline' => 'nullable|date', // Batas waktu pengulangan kursus opsional, harus berupa format tanggal
		// 	'remarks' => 'nullable|string', // Catatan kursus opsional, harus berupa string
		// 	'todo_type' => 'nullable|string|max:255', // Tipe tugas kursus opsional, harus berupa string dan maksimal 255 karakter
		// 	'todo_description' => 'nullable|string', // Deskripsi tugas kursus opsional, harus berupa string
		// 	'repeated_retest' => 'nullable|boolean', // Pengulangan tes kursus opsional, harus berupa boolean (true/false)
		// 	'test_passed_score' => 'nullable|numeric', // Skor lulus tes kursus opsional, harus berupa angka
		// 	'course_attributes_01' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		// 	'course_attributes_02' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		// 	'course_attributes_03' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		// 	'course_attributes_04' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		// 	'course_attributes_05' => 'nullable|string|max:255', // Atribut kursus opsional, harus berupa string dan maksimal 255 karakter
		// ]);

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
	public function attribute(Request $request, $attribute_id)
	{
		$html = "";
		$attribute = CourseAttributeSettingInformation::where('casi_id', $attribute_id)->latest()->first();
		if ($attribute) {
			$html = view('course_information.attributes', compact('attribute'))->render();
		}
		return [
			'html' => $html
		];
	}
}
