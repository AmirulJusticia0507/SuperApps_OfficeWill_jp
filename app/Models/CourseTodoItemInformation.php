<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


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

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('display_order', function (Builder $builder) {
			$builder->orderBy('display_order');
		});
	}

	public function choices()
	{
		return $this->hasMany(CourseTodoItemsChoiceInformation::class, 'todo_items_id', 'todo_item_id');
	}

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
