<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	private $tables = [
		'affiliation_information',
		'attendance_todo_answer_selection_information',
		'attendance_todo_item_answer_information',
		'company_information',
		'course_attribute_pulldown_settings',
		'course_attribute_setting_information',
		'course_classification_detail_information',
		'course_classification_information',
		'course_information',
		'course_material_information',
		'course_schedule_results_information',
		'course_todo_items_choice_information',
		'course_todo_item_information',
		'employee_affiliation_information',
		'employee_attribute_dropdown_settings_information',
		'employee_attribute_setting_information',
		'employee_information',
		'job_information',
		'questionnaire',
		'users'
	];
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{

		foreach ($this->tables as $tableName) {
			Schema::table($tableName, function (Blueprint $table) {
				$table->softDeletes();
			});
		}

	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		foreach ($this->tables as $tableName) {
			Schema::table($tableName, function (Blueprint $table) {
				$table->dropSoftDeletes();
			});
		}
	}
};
