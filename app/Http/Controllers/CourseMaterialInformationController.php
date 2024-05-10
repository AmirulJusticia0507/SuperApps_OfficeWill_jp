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
        CourseMaterialInformation::create($request->all());
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
        $material = CourseMaterialInformation::find($id);
        $material->update($request->all());
        return redirect()->route('materials.index')->with('success', 'Material updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseMaterialInformation::destroy($id);
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully');
    }
}
