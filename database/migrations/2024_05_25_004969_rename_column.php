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
		if (!Schema::hasTable('course_classification_detail_information') || !Schema::hasColumn('course_classification_detail_information', 'Course_classification_id')) {
			return;
		}

		Schema::table('course_classification_detail_information', function (Blueprint $table) {
			$table->renameColumn('Course_classification_id', 'course_classification_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		if (!Schema::hasTable('course_classification_detail_information') || !Schema::hasColumn('course_classification_detail_information', 'course_classification_id')) {
			return;
		}

		Schema::table('course_classification_detail_information', function (Blueprint $table) {
			$table->renameColumn('course_classification_id', 'Course_classification_id');
		});
	}
};
