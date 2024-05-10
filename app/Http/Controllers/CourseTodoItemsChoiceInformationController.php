<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseTodoItemsChoiceInformation;

class CourseTodoItemsChoiceInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $choices = CourseTodoItemsChoiceInformation::all();
        return view('course_todo_items_choice.index', compact('choices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_todo_items_choice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseTodoItemsChoiceInformation::create($request->all());
        return redirect()->route('choices.index')->with('success', 'Choice created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $choice = CourseTodoItemsChoiceInformation::find($id);
        return view('course_todo_items_choice.show', compact('choice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $choice = CourseTodoItemsChoiceInformation::find($id);
        return view('course_todo_items_choice.edit', compact('choice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $choice = CourseTodoItemsChoiceInformation::find($id);
        $choice->update($request->all());
        return redirect()->route('choices.index')->with('success', 'Choice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseTodoItemsChoiceInformation::destroy($id);
        return redirect()->route('choices.index')->with('success', 'Choice deleted successfully');
    }
}
