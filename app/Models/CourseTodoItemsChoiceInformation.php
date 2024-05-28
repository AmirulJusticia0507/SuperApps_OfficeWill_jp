<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


class CourseTodoItemsChoiceInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'todo_option_id',
        'todo_items_id',
        'course_id',
        'company_id',
        'display_order',
        'choices',
        'test_choice_correct_answer'
    ];

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('display_order', function (Builder $builder) {
			$builder->orderBy('display_order');
		});
	}

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
