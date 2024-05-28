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
		Schema::table('course_schedule_results_information', function (Blueprint $table) {
			$table->decimal('number_test_conducted', 3, 0)->default(0)->nullable()->change();
			$table->decimal('first_test_number_correct_answer', 3, 0)->default(0)->nullable()->after('number_test_conducted');
			$table->decimal('first_test_correct_answer_rate', 5, 2)->default(0)->nullable()->change();
			$table->decimal('latest_test_number_correct_answer', 3, 0)->default(0)->nullable()->change();
			$table->decimal('latest_test_accuracy_rate', 5, 2)->default(0)->nullable()->change();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('course_schedule_results_information', function (Blueprint $table) {
			$table->dropColumn('first_test_number_correct_answer');
		});
	}
};
