<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseClassificationInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_classification_information', function (Blueprint $table) {
            $table->id('course_classification_id');
            $table->string('course_classification_name');
            $table->string('icon_file_path')->nullable();
            $table->integer('displayorder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_classification_information');
    }
}
