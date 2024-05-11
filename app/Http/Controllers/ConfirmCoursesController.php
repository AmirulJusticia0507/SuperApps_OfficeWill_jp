<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseScheduleResultsInformation;

class ConfirmCoursesController extends Controller
{
    public function index()
    {
        // Ambil data kursus yang perlu dikonfirmasi
        $courses = CourseScheduleResultsInformation::all();

        // Kirim data ke view confirmcourses.blade.php
        return view('confirmcourses', compact('courses'));
    }
}
