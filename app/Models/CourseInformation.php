<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInformation extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'company_id', 'Course_classification_id', 'course_classification_details_id', 'coursename', 'coursename_kana', 'course_description', 'possible_retake_course_deadline', 'remarks', 'todo_type', 'todo_description', 'repeated_retest', 'test_passed_score', 'course_attributes_01', 'course_attributes_02', 'course_attributes_03', 'course_attributes_04', 'course_attributes_05'];

    // Fungsi CRUD

    // Create
    public static function createCourse($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourses()
    {
        return self::all();
    }

    public static function getCourseById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourse($id, $data)
    {
        $course = self::find($id);
        if ($course) {
            $course->update($data);
            return $course;
        }
        return null;
    }

    // Delete
    public static function deleteCourse($id)
    {
        $course = self::find($id);
        if ($course) {
            $course->delete();
            return true;
        }
        return false;
    }
}
