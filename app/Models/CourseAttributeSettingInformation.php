<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAttributeSettingInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['casi_id', 'company_id', 'course_attribute01_displayname', 'course_attribute01_displayrank', 'course_attribute01_screentype', 'course_attribute01_numberofscreen_digits', 'course_attribute01_attendance_selection', 'course_attribute02_displayname', 'course_attribute02_displayrank', 'course_attribute02_screentype', 'course_attribute02_numberofscreen_digits', 'course_attribute02_attendance_selection', 'course_attribute03_displayname', 'course_attribute03_displayrank', 'course_attribute03_screentype', 'course_attribute03_numberofscreen_digits', 'course_attribute03_attendance_selection', 'course_attribute04_displayname', 'course_attribute04_displayrank', 'course_attribute04_screentype', 'course_attribute04_numberofscreen_digits', 'course_attribute04_attendance_selection', 'course_attribute05_displayname', 'course_attribute05_displayrank', 'course_attribute05_screentype', 'course_attribute05_screen_columncount', 'course_attributes05_enrollment_selection'];

    // Fungsi CRUD

    // Create
    public static function createAttributeSetting($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllAttributeSettings()
    {
        return self::all();
    }

    public static function getAttributeSettingById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateAttributeSetting($id, $data)
    {
        $attributeSetting = self::find($id);
        if ($attributeSetting) {
            $attributeSetting->update($data);
            return $attributeSetting;
        }
        return null;
    }

    // Delete
    public static function deleteAttributeSetting($id)
    {
        $attributeSetting = self::find($id);
        if ($attributeSetting) {
            $attributeSetting->delete();
            return true;
        }
        return false;
    }
}
