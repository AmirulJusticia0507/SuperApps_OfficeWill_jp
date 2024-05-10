<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceTodoAnswerSelectionInformation extends Model
{
    use HasFactory;

    protected $fillable = ['atiasi_id', 'company_id', 'employee_id', 'course_id', 'attendance_setting_id', 'todo_items_id', 'todo_option_id', 'selection', 'other_text_answer'];

    // Fungsi CRUD

    // Create
    public static function createTodoAnswerSelection($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllTodoAnswerSelections()
    {
        return self::all();
    }

    public static function getTodoAnswerSelectionById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateTodoAnswerSelection($id, $data)
    {
        $todoAnswerSelection = self::find($id);
        if ($todoAnswerSelection) {
            $todoAnswerSelection->update($data);
            return $todoAnswerSelection;
        }
        return null;
    }

    // Delete
    public static function deleteTodoAnswerSelection($id)
    {
        $todoAnswerSelection = self::find($id);
        if ($todoAnswerSelection) {
            $todoAnswerSelection->delete();
            return true;
        }
        return false;
    }
}
