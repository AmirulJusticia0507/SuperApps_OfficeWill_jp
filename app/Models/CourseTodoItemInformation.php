<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTodoItemInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'todo_item_id',
        'course_id',
        'company_id',
        'display_order',
        'question',
        'answer_type',
        'required_settings',
        'test_explained'
    ];

    // Fungsi CRUD

    // Create
    public static function createCourseTodoItem($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourseTodoItems()
    {
        return self::all();
    }

    public static function getCourseTodoItemById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourseTodoItem($id, $data)
    {
        $courseTodoItem = self::find($id);
        if ($courseTodoItem) {
            $courseTodoItem->update($data);
            return $courseTodoItem;
        }
        return null;
    }

    // Delete
    public static function deleteCourseTodoItem($id)
    {
        $courseTodoItem = self::find($id);
        if ($courseTodoItem) {
            $courseTodoItem->delete();
            return true;
        }
        return false;
    }
}
