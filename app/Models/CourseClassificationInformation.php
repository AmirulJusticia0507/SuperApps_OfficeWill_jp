<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClassificationInformation extends Model
{
    use HasFactory;

    protected $fillable = ['course_classification_id', 'company_id', 'course_classification_name', 'icon_file_path', 'displayorder'];

    // Nonaktifkan timestamps
    public $timestamps = false;

    // Fungsi CRUD

    // Create
    public static function createCourseClassification($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourseClassifications()
    {
        return self::all();
    }

    public static function getCourseClassificationById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourseClassification($id, $data)
    {
        $courseClassification = self::find($id);
        if ($courseClassification) {
            $courseClassification->update($data);
            return $courseClassification;
        }
        return null;
    }

    // Delete
    public static function deleteCourseClassification($id)
    {
        $courseClassification = self::find($id);
        if ($courseClassification) {
            $courseClassification->delete();
            return true;
        }
        return false;
    }
}
