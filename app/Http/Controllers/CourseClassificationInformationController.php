<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseClassificationInformation;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
class CourseClassificationInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = CourseClassificationInformation::all();
        $companies = CompanyInformation::all(); // Mengambil daftar perusahaan
        return view('course_classification.index', compact('classifications', 'companies'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = CompanyInformation::all();
        return view('course_classification.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:20'],
            'classification_name' => ['required', 'string', 'max:10'],
            'display_order' => ['required', 'string'],
            'icon_file_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $company = CompanyInformation::where('company_name', $data['company_name'])->firstOrFail();
        $iconPath = $this->storeIcon($request);
        
        $classification = new CourseClassificationInformation();
        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $data['classification_name'];
        $classification->icon_file_path = $iconPath;
        $classification->displayorder = str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT);
        $classification->save();

        return redirect()->route('course-classification.index')->with('success', 'Classification created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $classification = CourseClassificationInformation::findOrFail($id);
        $companies = CompanyInformation::all();
        return view('course_classification.edit', compact('classification', 'companies'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:20'],
            'classification_name' => ['required', 'string', 'max:10'],
            'display_order' => ['required', 'string'],
            'icon_file_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $classification = CourseClassificationInformation::findOrFail($id);
        $company = CompanyInformation::where('company_name', $data['company_name'])->firstOrFail();
        abort_unless((int) $company->company_id === (int) $classification->company_id, 403);

        if ($request->hasFile('icon_file_path')) {
            if ($classification->icon_file_path) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $classification->icon_file_path), '/'));
            }
            $iconPath = $this->storeIcon($request);
            $classification->icon_file_path = $iconPath;
        }

        $classification->company_id = $company->company_id;
        $classification->course_classification_name = $data['classification_name'];
        $classification->displayorder = str_pad((string) $data['display_order'], 3, '0', STR_PAD_LEFT);
        $classification->save();

        return redirect()->route('course-classification.index')->with('success', 'Classification updated successfully');
    }

    private function storeIcon(Request $request): string
    {
        $file = $request->file('icon_file_path');

        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages([
                'icon_file_path' => $file?->getErrorMessage() ?? 'The icon upload was not received.',
            ]);
        }

        $path = $file->store('icons', 'public');

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
        $classification = CourseClassificationInformation::findOrFail($id);
        $classification->delete();
        return redirect()->route('course-classification.index')->with('success', 'Classification deleted successfully');
    }
    
}
