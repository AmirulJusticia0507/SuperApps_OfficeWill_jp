<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAttributePulldownSettings;
use App\Http\Controllers\Concerns\ValidatesModelInput;

class CourseAttributePulldownSettingsController extends Controller
{
    use ValidatesModelInput;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = CourseAttributePulldownSettings::all();
        return view('course_attribute_pulldown_settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_attribute_pulldown_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseAttributePulldownSettings::create($this->validatedModelInput($request, new CourseAttributePulldownSettings()));
        return redirect()->route('settings.index')->with('success', 'Settings created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $setting = CourseAttributePulldownSettings::find($id);
        return view('course_attribute_pulldown_settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = CourseAttributePulldownSettings::find($id);
        return view('course_attribute_pulldown_settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = CourseAttributePulldownSettings::findOrFail($id);
        $setting->update($this->validatedModelInput($request, $setting));
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseAttributePulldownSettings::findOrFail($id)->delete();
        return redirect()->route('settings.index')->with('success', 'Settings deleted successfully');
    }
}
