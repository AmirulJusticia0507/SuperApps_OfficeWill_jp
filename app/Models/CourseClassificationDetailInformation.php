<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseClassificationDetailInformation extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'course_classification_details_id';


	protected $fillable = ['course_classification_details_id', 'course_classification_id', 'company_id', 'course_classification_detailsname', 'icon_file_path', 'display_order'];
    public $timestamps = false;
    // Fungsi CRUD

    // Create
    public static function createCourseClassificationDetail($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourseClassificationDetails()
    {
        return self::all();
    }

    public static function getCourseClassificationDetailById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourseClassificationDetail($id, $data)
    {
        $courseClassificationDetail = self::find($id);
        if ($courseClassificationDetail) {
            $courseClassificationDetail->update($data);
            return $courseClassificationDetail;
        }
        return null;
    }

    // Delete
    public static function deleteCourseClassificationDetail($id)
    {
        $courseClassificationDetail = self::find($id);
        if ($courseClassificationDetail) {
            $courseClassificationDetail->delete();
            return true;
        }
        return false;
    }

    public function classification()
    {
		return $this->belongsTo(CourseClassificationInformation::class, 'course_classification_id', 'course_classification_id');
    }

}
