<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceTodoItemAnswerInformation;

class AttendanceTodoItemAnswerInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = AttendanceTodoItemAnswerInformation::all();
        return view('answer.index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('answer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        AttendanceTodoItemAnswerInformation::create($request->all());
        return redirect()->route('answers.index')->with('success', 'Answer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $answer = AttendanceTodoItemAnswerInformation::find($id);
        return view('answer.show', compact('answer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $answer = AttendanceTodoItemAnswerInformation::find($id);
        return view('answer.edit', compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $answer = AttendanceTodoItemAnswerInformation::find($id);
        $answer->update($request->all());
        return redirect()->route('answers.index')->with('success', 'Answer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AttendanceTodoItemAnswerInformation::destroy($id);
        return redirect()->route('answers.index')->with('success', 'Answer deleted successfully');
    }
}
