<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAffiliationInformation;
use App\Http\Controllers\Concerns\ValidatesModelInput;

class EmployeeAffiliationInformationController extends Controller
{
    use ValidatesModelInput;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affiliations = EmployeeAffiliationInformation::all();
        return view('employee_affiliation.index', compact('affiliations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee_affiliation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        EmployeeAffiliationInformation::create($this->validatedModelInput($request, new EmployeeAffiliationInformation()));
        return redirect()->route('affiliations.index')->with('success', 'Affiliation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $affiliation = EmployeeAffiliationInformation::find($id);
        return view('employee_affiliation.show', compact('affiliation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $affiliation = EmployeeAffiliationInformation::find($id);
        return view('employee_affiliation.edit', compact('affiliation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $affiliation = EmployeeAffiliationInformation::findOrFail($id);
        $affiliation->update($this->validatedModelInput($request, $affiliation));
        return redirect()->route('affiliations.index')->with('success', 'Affiliation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EmployeeAffiliationInformation::findOrFail($id)->delete();
        return redirect()->route('affiliations.index')->with('success', 'Affiliation deleted successfully');
    }
}
