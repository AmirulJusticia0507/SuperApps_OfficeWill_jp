<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAttributeSettingInformation;

class CourseAttributeSettingInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = CourseAttributeSettingInformation::all();
        return view('course_attribute_setting_information.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_attribute_setting_information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseAttributeSettingInformation::create($request->all());
        return redirect()->route('settings.index')->with('success', 'Settings created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $setting = CourseAttributeSettingInformation::find($id);
        return view('course_attribute_setting_information.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = CourseAttributeSettingInformation::find($id);
        return view('course_attribute_setting_information.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = CourseAttributeSettingInformation::find($id);
        $setting->update($request->all());
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseAttributeSettingInformation::destroy($id);
        return redirect()->route('settings.index')->with('success', 'Settings deleted successfully');
    }
}
