<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInformation extends Model
{
    use HasFactory;
    protected $table = 'course_information';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'company_id',
        'course_classification_id',
        'course_classification_details_id',
        'coursename',
        'coursename_kana',
        'course_description',
        'possible_retake_course_deadline',
        'remarks',
        'todo_type',
        'todo_description',
        'repeated_retest',
        'test_passed_score',
        'course_attributes_01',
        'course_attributes_02',
        'course_attributes_03',
        'course_attributes_04',
        'course_attributes_05'
    ];

    public $timestamps = false;
}
