<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAttributeSettingInformation;
use App\Http\Controllers\Concerns\ValidatesModelInput;

class EmployeeAttributeSettingInformationController extends Controller
{
    use ValidatesModelInput;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = EmployeeAttributeSettingInformation::all();
        return view('employee_attribute_setting.index', compact('employee-settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee_attribute_setting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        EmployeeAttributeSettingInformation::create($this->validatedModelInput($request, new EmployeeAttributeSettingInformation()));
        return redirect()->route('settings.index')->with('success', 'Settings created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $setting = EmployeeAttributeSettingInformation::find($id);
        return view('employee_attribute_setting.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = EmployeeAttributeSettingInformation::find($id);
        return view('employee_attribute_setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $setting = EmployeeAttributeSettingInformation::findOrFail($id);
        $setting->update($this->validatedModelInput($request, $setting));
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EmployeeAttributeSettingInformation::findOrFail($id)->delete();
        return redirect()->route('settings.index')->with('success', 'Settings deleted successfully');
    }
}
