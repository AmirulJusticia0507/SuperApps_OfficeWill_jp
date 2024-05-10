<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAttributeDropdownSettingsInformation;

class EmployeeAttributeDropdownSettingsInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = EmployeeAttributeDropdownSettingsInformation::all();
        return view('employee_attribute_dropdown_settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee_attribute_dropdown_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        EmployeeAttributeDropdownSettingsInformation::create($request->all());
        return redirect()->route('settings.index')->with('success', 'Settings created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $setting = EmployeeAttributeDropdownSettingsInformation::find($id);
        return view('employee_attribute_dropdown_settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = EmployeeAttributeDropdownSettingsInformation::find($id);
        return view('employee_attribute_dropdown_settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = EmployeeAttributeDropdownSettingsInformation::find($id);
        $setting->update($request->all());
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EmployeeAttributeDropdownSettingsInformation::destroy($id);
        return redirect()->route('settings.index')->with('success', 'Settings deleted successfully');
    }
}
