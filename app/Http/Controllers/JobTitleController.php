<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobInformation;

class JobTitleController extends Controller
{
    public function index()
    {
        $jobTitles = JobInformation::all();
        $isEditing = false; // Tambahkan variabel untuk menandai apakah sedang dalam mode edit
        $editingId = null; // Tambahkan variabel untuk menyimpan ID yang sedang diedit
        return view('job-titles.index', compact('jobTitles', 'isEditing', 'editingId'));
    }

    public function create()
    {
        return view('job-titles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'JobTitle' => 'required',
            'DisplayOrder' => 'required|numeric',
        ]);

        JobInformation::create([
            'JobTitle' => $request->JobTitle,
            'DisplayOrder' => $request->DisplayOrder,
        ]);

        return redirect()->route('job-titles.index')->with('success', 'Job Title created successfully.');
    }

    public function show($id)
    {
        $jobTitle = JobInformation::findOrFail($id);
        return view('job-titles.show', compact('jobTitle'));
    }

    public function edit($id)
    {
        $jobTitle = JobInformation::findOrFail($id);
        $isEditing = true; // Setel variabel untuk menandai bahwa sedang dalam mode edit
        $editingId = $id; // Setel ID yang sedang diedit
        return view('job-titles.index', compact('jobTitle', 'isEditing', 'editingId'));
    }    

    public function update(Request $request, $id)
    {
        $request->validate([
            'JobTitle' => 'required',
            'DisplayOrder' => 'required|numeric',
        ]);

        $jobTitle = JobInformation::findOrFail($id);
        $jobTitle->update([
            'JobTitle' => $request->JobTitle,
            'DisplayOrder' => $request->DisplayOrder,
        ]);

        return redirect()->route('job-titles.index')->with('success', 'Job Title updated successfully.');
    }

    public function destroy($id)
    {
        $jobTitle = JobInformation::findOrFail($id);
        $jobTitle->delete();
        return redirect()->route('job-titles.index')->with('success', 'Job Title deleted successfully.');
    }
}
