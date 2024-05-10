<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTodoItemsChoiceInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_option_id',
        'todo_items_id',
        'course_id',
        'company_id',
        'display_order',
        'choices',
        'test_choice_correct_answer'
    ];

    // Fungsi CRUD

    // Create
    public static function createCourseTodoItemsChoice($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllCourseTodoItemsChoices()
    {
        return self::all();
    }

    public static function getCourseTodoItemsChoiceById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateCourseTodoItemsChoice($id, $data)
    {
        $courseTodoItemsChoice = self::find($id);
        if ($courseTodoItemsChoice) {
            $courseTodoItemsChoice->update($data);
            return $courseTodoItemsChoice;
        }
        return null;
    }

    // Delete
    public static function deleteCourseTodoItemsChoice($id)
    {
        $courseTodoItemsChoice = self::find($id);
        if ($courseTodoItemsChoice) {
            $courseTodoItemsChoice->delete();
            return true;
        }
        return false;
    }
}
