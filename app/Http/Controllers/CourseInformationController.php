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

	/** Display the selected course details. */
	public function show(string $id)
	{
		$course = CourseInformation::with(['classification', 'classification_detail', 'material', 'todo.choices'])
			->findOrFail($id);

		return view('course_information.show', compact('course'));
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
		$data = $request->validate([
			'course_classification_id' => ['required', 'integer'],
			'course_classification_details_id' => ['required', 'integer'],
			'coursename' => ['required', 'string', 'max:30'],
			'coursename_kana' => ['nullable', 'string', 'max:30'],
			'course_description' => ['required', 'string'],
			'possible_retake_course_deadline' => ['required', 'in:1,2'],
			'remarks' => ['nullable', 'string', 'max:255'],
			'todo_type' => ['required', 'in:1,2,3'],
			'todo_description' => ['required', 'string'],
			'repeated_retest' => ['required', 'in:1,2'],
			'test_passed_score' => ['nullable', 'numeric', 'between:0,100'],
			'course_attributes_01' => ['nullable', 'string', 'max:255'],
			'course_attributes_02' => ['nullable', 'string', 'max:255'],
			'course_attributes_03' => ['nullable', 'string', 'max:255'],
			'course_attributes_04' => ['nullable', 'string', 'max:255'],
			'course_attributes_05' => ['nullable', 'string', 'max:255'],
			'teaching_material' => ['required', 'array', 'min:1', 'max:50'],
			'teaching_material.*.teaching_material_name' => ['required', 'string', 'max:20'],
			'teaching_material.*.material_type' => ['required', 'in:1,2'],
			'teaching_material.*.youtube_video_url' => ['nullable', 'url', 'max:255'],
			'teaching_material.*.bookfile' => ['nullable', 'file', 'max:20480'],
			'todo' => ['sometimes', 'array', 'max:100'],
			'todo.*.question' => ['required', 'string', 'max:255'],
			'todo.*.answer_type' => ['required', 'in:1,2,3,4'],
			'todo.*.answer_input' => ['nullable', 'in:1,2'],
			'todo.*.explanation' => ['nullable', 'string'],
			'todo.*.correct_answer' => ['nullable', 'integer', 'min:0'],
			'todo.*.option' => ['sometimes', 'array'],
			'todo.*.option.*' => ['nullable', 'string', 'max:50'],
		]);

		$classification = CourseClassificationInformation::findOrFail($data['course_classification_id']);
		$detail = CourseClassificationDetailInformation::where('course_classification_details_id', $data['course_classification_details_id'])
			->where('course_classification_id', $classification->course_classification_id)
			->firstOrFail();
		$companyId = $classification->company_id;

		DB::transaction(function () use ($data, $classification, $detail, $companyId) {
			$course = CourseInformation::create([
				'company_id' => $companyId,
				'course_classification_id' => $classification->course_classification_id,
				'course_classification_details_id' => $detail->course_classification_details_id,
				'coursename' => $data['coursename'],
				'coursename_kana' => $data['coursename_kana'] ?? '',
				'course_description' => $data['course_description'],
				'possible_retake_course_deadline' => $data['possible_retake_course_deadline'],
				'remarks' => $data['remarks'] ?? '',
				'todo_type' => $data['todo_type'],
				'todo_description' => $data['todo_description'],
				'repeated_retest' => $data['repeated_retest'],
				'test_passed_score' => $data['test_passed_score'] ?? 0,
				'course_attributes_01' => $data['course_attributes_01'] ?? '',
				'course_attributes_02' => $data['course_attributes_02'] ?? '',
				'course_attributes_03' => $data['course_attributes_03'] ?? '',
				'course_attributes_04' => $data['course_attributes_04'] ?? '',
				'course_attributes_05' => $data['course_attributes_05'] ?? '',
			]);

			foreach ($data['teaching_material'] as $index => $material) {
				$bookFilePath = isset($material['bookfile'])
					? $material['bookfile']->store('teaching_materials/' . $companyId, 'public')
					: null;

				CourseMaterialInformation::create([
					'course_id' => $course->course_id,
					'company_id' => $companyId,
					'display_order' => str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
					'teaching_material_name' => $material['teaching_material_name'],
					'material_type' => $material['material_type'],
					'youtube_video_url' => $material['youtube_video_url'] ?? null,
					'book_file_path' => $bookFilePath,
				]);
			}

			foreach ($data['todo'] ?? [] as $todoOrder => $todo) {
				$todoItem = CourseTodoItemInformation::create([
					'course_id' => $course->course_id,
					'company_id' => $companyId,
					'display_order' => str_pad((string) ($todoOrder + 1), 3, '0', STR_PAD_LEFT),
					'question' => $todo['question'],
					'answer_type' => $todo['answer_type'],
					'required_settings' => $todo['answer_input'] ?? null,
					'test_explained' => $data['todo_type'] === '2' ? ($todo['explanation'] ?? null) : null,
				]);

				foreach ($todo['option'] ?? [] as $optionOrder => $option) {
					CourseTodoItemsChoiceInformation::create([
						'todo_items_id' => $todoItem->todo_item_id,
						'course_id' => $course->course_id,
						'company_id' => $companyId,
						'display_order' => str_pad((string) ($optionOrder + 1), 3, '0', STR_PAD_LEFT),
						'choices' => $option,
						'test_choice_correct_answer' => (string) $optionOrder === (string) ($todo['correct_answer'] ?? '') ? '1' : '0',
					]);
				}
			}
		});

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
		$course = CourseInformation::findOrFail($id);
		$data = $request->validate([
			'course_classification_id' => ['sometimes', 'required', 'integer'],
			'course_classification_details_id' => ['sometimes', 'required', 'integer'],
			'coursename' => ['sometimes', 'required', 'string', 'max:30'],
			'coursename_kana' => ['sometimes', 'nullable', 'string', 'max:30'],
			'course_description' => ['sometimes', 'nullable', 'string'],
			'possible_retake_course_deadline' => ['sometimes', 'required', 'in:1,2'],
			'remarks' => ['sometimes', 'nullable', 'string', 'max:255'],
			'todo_type' => ['sometimes', 'nullable', 'in:1,2,3'],
			'todo_description' => ['sometimes', 'nullable', 'string'],
			'repeated_retest' => ['sometimes', 'required', 'in:1,2'],
			'test_passed_score' => ['sometimes', 'nullable', 'numeric', 'between:0,100'],
			'course_attributes_01' => ['sometimes', 'nullable', 'string', 'max:255'],
			'course_attributes_02' => ['sometimes', 'nullable', 'string', 'max:255'],
			'course_attributes_03' => ['sometimes', 'nullable', 'string', 'max:255'],
			'course_attributes_04' => ['sometimes', 'nullable', 'string', 'max:255'],
			'course_attributes_05' => ['sometimes', 'nullable', 'string', 'max:255'],
		]);

		if (isset($data['course_classification_id'])) {
			$classification = CourseClassificationInformation::findOrFail($data['course_classification_id']);
			abort_unless((int) $classification->company_id === (int) $course->company_id, 403);
		}
		if (isset($data['course_classification_details_id'])) {
			$detail = CourseClassificationDetailInformation::findOrFail($data['course_classification_details_id']);
			abort_unless((int) $detail->company_id === (int) $course->company_id, 403);
		}

		$course->update($data);
		return redirect()->route('course-list')->with('success', 'Course updated successfully');
	}
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		CourseInformation::findOrFail($id)->delete();
		return redirect()->route('course-list')->with('success', 'Course deleted successfully');
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
