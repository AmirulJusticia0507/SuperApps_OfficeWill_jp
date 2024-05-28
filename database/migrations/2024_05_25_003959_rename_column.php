<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('course_information', function (Blueprint $table) {
			$table->renameColumn('Course_classification_id', 'course_classification_id');
			$table->string('course_attributes_01')->nullable()->change();
			$table->string('course_attributes_02')->nullable()->change();
			$table->string('course_attributes_03')->nullable()->change();
			$table->string('course_attributes_04')->nullable()->change();
			$table->string('course_attributes_05')->nullable()->change();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('course_information', function (Blueprint $table) {
			$table->renameColumn('course_classification_id', 'Course_classification_id');
		});
	}
};
