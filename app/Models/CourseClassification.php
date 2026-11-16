<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\BelongsToCompany;

class CourseClassification extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $table = 'course_classification_information';
    protected $primaryKey = 'course_classification_id';
    // Define relationships if needed
}
