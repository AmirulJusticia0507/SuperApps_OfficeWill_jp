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
        $jobTitle = null;
        $jobTitles = JobInformation::all();
        return view('job-titles.edit', compact('jobTitle', 'jobTitles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_title' => ['required', 'string', 'max:20'],
            'display_order' => ['required', 'integer', 'between:1,999'],
        ]);

        JobInformation::create($data);

        return redirect()->route('job-titles.index')->with('success', 'Job Title created successfully.');
    }

    public function show($id)
    {
        return redirect()->route('job-titles.edit', $id);
    }

    public function edit($id)
    {
        $jobTitle = JobInformation::findOrFail($id);
        $jobTitles = JobInformation::all();
        $isEditing = true; // Setel variabel untuk menandai bahwa sedang dalam mode edit
        $editingId = $id; // Setel ID yang sedang diedit
        return view('job-titles.edit', compact('jobTitle', 'jobTitles', 'isEditing', 'editingId'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'job_title' => ['required', 'string', 'max:20'],
            'display_order' => ['required', 'integer', 'between:1,999'],
        ]);

        $jobTitle = JobInformation::findOrFail($id);
        $jobTitle->update($data);

        return redirect()->route('job-titles.index')->with('success', 'Job Title updated successfully.');
    }

    public function destroy($id)
    {
        $jobTitle = JobInformation::findOrFail($id);
        $jobTitle->delete();
        return redirect()->route('job-titles.index')->with('success', 'Job Title deleted successfully.');
    }
}
