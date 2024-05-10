<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttributePulldownSettings extends Model
{
    use HasFactory;

    protected $fillable = ['capsi_id', 'company_id', 'course_attribute_number', 'pulldown_list_1', 'pulldown_list_2', 'pulldown_list_3', 'pulldown_list_4', 'pulldown_list_5', 'pulldown_list_6', 'pulldown_list_7', 'pulldown_list_8', 'pulldown_list_9', 'pulldown_list_10'];

    // Fungsi CRUD

    // Create
    public static function createAttributePulldown($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllAttributePulldowns()
    {
        return self::all();
    }

    public static function getAttributePulldownById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateAttributePulldown($id, $data)
    {
        $attributePulldown = self::find($id);
        if ($attributePulldown) {
            $attributePulldown->update($data);
            return $attributePulldown;
        }
        return null;
    }

    // Delete
    public static function deleteAttributePulldown($id)
    {
        $attributePulldown = self::find($id);
        if ($attributePulldown) {
            $attributePulldown->delete();
            return true;
        }
        return false;
    }
}
