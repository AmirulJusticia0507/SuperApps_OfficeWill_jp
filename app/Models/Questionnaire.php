<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = 'questionnaire';
    protected $fillable = ['question_text', 'answer_type', 'is_required', 'response_text', 'employee_id', 'question_id', 'answered'];
}
