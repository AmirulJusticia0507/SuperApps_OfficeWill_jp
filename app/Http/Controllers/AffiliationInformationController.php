<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliationInformation;

class AffiliationInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affiliations = AffiliationInformation::all();
        return view('affiliation_information.index', compact('affiliations'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('affiliation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        AffiliationInformation::create($request->all());
        return redirect()->route('affiliations.index')->with('success', 'Affiliation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        return view('affiliation.show', compact('affiliation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        return view('affiliation.edit', compact('affiliation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $affiliation = AffiliationInformation::find($id);
        $affiliation->update($request->all());
        return redirect()->route('affiliations.index')->with('success', 'Affiliation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AffiliationInformation::destroy($id);
        return redirect()->route('affiliations.index')->with('success', 'Affiliation deleted successfully');
    }

    public function showCourseSettings()
    {
        $affiliations = AffiliationInformation::all();
        return view('coursesettings', compact('affiliations'));
    }
}
