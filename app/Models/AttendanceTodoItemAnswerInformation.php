<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceTodoItemAnswerInformation extends Model
{
    use HasFactory;

    protected $fillable = ['atiai_id', 'company_id', 'employee_id', 'course_id', 'attendance_settings_id', 'todo_items_id', 'text_answer', 'report'];

    // Fungsi CRUD

    // Create
    public static function createTodoItemAnswer($data)
    {
        return self::create($data);
    }

    // Read
    public static function getAllTodoItemAnswers()
    {
        return self::all();
    }

    public static function getTodoItemAnswerById($id)
    {
        return self::find($id);
    }

    // Update
    public static function updateTodoItemAnswer($id, $data)
    {
        $todoItemAnswer = self::find($id);
        if ($todoItemAnswer) {
            $todoItemAnswer->update($data);
            return $todoItemAnswer;
        }
        return null;
    }

    // Delete
    public static function deleteTodoItemAnswer($id)
    {
        $todoItemAnswer = self::find($id);
        if ($todoItemAnswer) {
            $todoItemAnswer->delete();
            return true;
        }
        return false;
    }
}
