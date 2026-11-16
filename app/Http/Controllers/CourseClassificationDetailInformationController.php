<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationDetailInformation;
use App\Models\CourseClassificationInformation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CourseClassificationDetailInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = CourseClassificationDetailInformation::all();
        $classifications = CourseClassificationInformation::all();
        return view('course_classification_details.index', compact('details', 'classifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classifications = CourseClassificationInformation::all();
        return view('course_classification_details.create', compact('classifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
			'course_classification_id' => ['required', 'integer'],
            'course_classification_detailsname' => ['required', 'string', 'max:255'],
            'display_order' => ['required', 'string'],
            'icon_file_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $classification = CourseClassificationInformation::findOrFail($data['course_classification_id']);
        $detail = new CourseClassificationDetailInformation();
		$detail->course_classification_id = $classification->course_classification_id;
        $detail->company_id = $classification->company_id;
        $detail->course_classification_detailsname = $data['course_classification_detailsname'];
        $detail->display_order = str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT);

        // Handle file upload
        if ($request->hasFile('icon_file_path')) {
            $imagePath = $this->storeIcon($request);
            $detail->icon_file_path = $imagePath;
        }

        $detail->save();

        return redirect()->route('details.index')->with('success', 'Detail created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $detail = CourseClassificationDetailInformation::findOrFail($id);
        $classifications = CourseClassificationInformation::all();
        return view('course_classification_details.edit', compact('detail', 'classifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
			'course_classification_id' => ['required', 'integer'],
            'course_classification_detailsname' => ['required', 'string', 'max:255'],
            'display_order' => ['required', 'string'],
            'icon_file_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $detail = CourseClassificationDetailInformation::findOrFail($id);
        $classification = CourseClassificationInformation::findOrFail($data['course_classification_id']);
        abort_unless((int) $classification->company_id === (int) $detail->company_id, 403);
		$detail->course_classification_id = $classification->course_classification_id;
        $detail->course_classification_detailsname = $data['course_classification_detailsname'];
        $detail->display_order = str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT);

        // Handle file upload
        if ($request->hasFile('icon_file_path')) {
            // Delete previous file if exists
            if ($detail->icon_file_path) {
                Storage::disk('public')->delete($detail->icon_file_path);
            }
            $imagePath = $this->storeIcon($request);
            $detail->icon_file_path = $imagePath;
        }

        $detail->save();

        return redirect()->route('details.index')->with('success', 'Detail updated successfully');
    }

    private function storeIcon(Request $request): string
    {
        $file = $request->file('icon_file_path');

        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages([
                'icon_file_path' => $file?->getErrorMessage() ?? 'The icon upload was not received.',
            ]);
        }

        $path = $file->store('course_classification_icons', 'public');

        if ($path === false) {
            throw ValidationException::withMessages([
                'icon_file_path' => 'The icon could not be stored.',
            ]);
        }

        return $path;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = CourseClassificationDetailInformation::find($id);
        if ($detail) {
            // Delete associated file
            if ($detail->icon_file_path) {
                Storage::disk('public')->delete($detail->icon_file_path);
            }
            $detail->delete();
            return redirect()->route('details.index')->with('success', 'Detail deleted successfully');
        } else {
            return redirect()->route('details.index')->with('error', 'Detail not found');
        }
    }
}
