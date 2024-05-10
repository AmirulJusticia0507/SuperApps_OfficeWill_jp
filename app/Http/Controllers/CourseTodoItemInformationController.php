<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseTodoItemInformation;

class CourseTodoItemInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todoItems = CourseTodoItemInformation::all();
        return view('course_todo_item.index', compact('todoItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course_todo_item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CourseTodoItemInformation::create($request->all());
        return redirect()->route('todo_items.index')->with('success', 'Todo item created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todoItem = CourseTodoItemInformation::find($id);
        return view('course_todo_item.show', compact('todoItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todoItem = CourseTodoItemInformation::find($id);
        return view('course_todo_item.edit', compact('todoItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todoItem = CourseTodoItemInformation::find($id);
        $todoItem->update($request->all());
        return redirect()->route('todo_items.index')->with('success', 'Todo item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CourseTodoItemInformation::destroy($id);
        return redirect()->route('todo_items.index')->with('success', 'Todo item deleted successfully');
    }
}
