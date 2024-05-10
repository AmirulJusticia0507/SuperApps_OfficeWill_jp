<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseScheduleResultsInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_setting_id',
        'course_id',
        'employee_id',
        'company_id',
        'schedule_course',
        'course_information',
        'deadline_enrollment',
        'todo_progress',
        'todo_complete',
        'number_test_conducted',
        'first_test_correct_answer_rate',
        'latest_test_number_correct_answer',
        'latest_test_accuracy_rate'
    ];

    // Fungsi CRUD

    // Create
    public static function createCourseScheduleResult($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourseScheduleResults()
    {
        return self::all();
    }

    public static function getCourseScheduleResultById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourseScheduleResult($id, $data)
    {
        $courseScheduleResult = self::find($id);
        if ($courseScheduleResult) {
            $courseScheduleResult->update($data);
            return $courseScheduleResult;
        }
        return null;
    }

    // Delete
    public static function deleteCourseScheduleResult($id)
    {
        $courseScheduleResult = self::find($id);
        if ($courseScheduleResult) {
            $courseScheduleResult->delete();
            return true;
        }
        return false;
    }
}
