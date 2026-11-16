<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseMaterialInformation;

class CourseMaterialInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = CourseMaterialInformation::all();
        return view('course_material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'integer'],
            'display_order' => ['required', 'integer', 'between:1,999'],
            'teaching_material_name' => ['required', 'string', 'max:20'],
            'material_type' => ['required', 'in:Video,Books,1,2'],
            'youtube_video_url' => ['nullable', 'url', 'max:255'],
            'bookfile' => ['nullable', 'file', 'max:20480'],
        ]);
        $course = \App\Models\CourseInformation::findOrFail($data['course_id']);
        $data['company_id'] = $course->company_id;
        $data['display_order'] = str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT);
        $data['book_file_path'] = $request->file('bookfile')?->store('teaching_materials/' . $course->company_id, 'public');
        unset($data['bookfile']);
        CourseMaterialInformation::create($data);
        return redirect()->route('materials.index')->with('success', 'Material created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = CourseMaterialInformation::find($id);
        return view('course_material.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material = CourseMaterialInformation::find($id);
        return view('course_material.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = CourseMaterialInformation::findOrFail($id);
        $data = $request->validate([
            'course_id' => ['sometimes', 'required', 'integer'],
            'display_order' => ['sometimes', 'required', 'integer', 'between:1,999'],
            'teaching_material_name' => ['sometimes', 'required', 'string', 'max:20'],
            'material_type' => ['sometimes', 'required', 'in:Video,Books,1,2'],
            'youtube_video_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'bookfile' => ['sometimes', 'nullable', 'file', 'max:20480'],
        ]);
        if (isset($data['course_id'])) {
            $course = \App\Models\CourseInformation::findOrFail($data['course_id']);
            abort_unless((int) $course->company_id === (int) $material->company_id, 403);
        }
        if (isset($data['display_order'])) {
            $data['display_order'] = str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT);
        }
        if ($request->hasFile('bookfile')) {
            $data['book_file_path'] = $request->file('bookfile')->store('teaching_materials/' . $material->company_id, 'public');
        }
        unset($data['bookfile']);
        $material->update($data);
        return redirect()->route('materials.index')->with('success', 'Material updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseMaterialInformation::findOrFail($id)->delete();
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully');
    }
}
