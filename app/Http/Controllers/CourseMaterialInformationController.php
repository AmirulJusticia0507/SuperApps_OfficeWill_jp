<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseMaterialInformation;
use App\Models\CompanyInformation;
use Illuminate\Support\Facades\Storage;

class CourseMaterialInformationController extends Controller
{
    public function index()
    {
        $companies = CompanyInformation::all();
        $materials = CourseMaterialInformation::all();
        return view('course_material.index', compact('materials', 'companies'));
    }    

    public function create()
    {
        $companies = CompanyInformation::all();
        return view('course_material.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:company_information,id',
            'teaching_material_name' => 'required',
            'material_type' => 'required',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('bookfile')) {
            $bookFilePath = $request->file('bookfile')->store('books', 'public');
            $request->merge(['book_file_path' => $bookFilePath]);
        }

        CourseMaterialInformation::create($request->all());
    
        return redirect()->route('materials.index')->with('success', 'Material created successfully');
    }
}
