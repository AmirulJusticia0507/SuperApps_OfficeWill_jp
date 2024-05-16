<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterialInformation extends Model
{
    use HasFactory;
    protected $primaryKey = 'material_id';

    protected $fillable = [
        'company_id',
        'Course_id',
        'display_order',
        'teaching_material_name',
        'material_type',
        'youtube_video_url',
        'book_file_path'
    ];

    public $timestamps = false;
    // Fungsi CRUD

    // Create
    public static function createCourseMaterial($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourseMaterials()
    {
        return self::all();
    }

    public static function getCourseMaterialById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourseMaterial($id, $data)
    {
        $courseMaterial = self::find($id);
        if ($courseMaterial) {
            $courseMaterial->update($data);
            return $courseMaterial;
        }
        return null;
    }

    // Delete
    public static function deleteCourseMaterial($id)
    {
        $courseMaterial = self::find($id);
        if ($courseMaterial) {
            $courseMaterial->delete();
            return true;
        }
        return false;
    }
}
