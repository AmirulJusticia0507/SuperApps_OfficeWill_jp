<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		if (!Schema::hasTable('affiliation_information')) {
			Schema::create('affiliation_information', function (Blueprint $table) {
				$table->integer('affiliation_code')->primary();
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->string('affiliation_name')->nullable();
				$table->string('display_order', 3)->nullable();
				$table->string('organization_type')->nullable();
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('job_information')) {
			Schema::create('job_information', function (Blueprint $table) {
				$table->increments('job_id');
				$table->integer('company_id')->default(0);
				$table->string('job_title', 10)->nullable();
				$table->string('display_order', 3)->nullable();
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('employee_information')) {
			Schema::create('employee_information', function (Blueprint $table) {
				$table->increments('employee_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->string('fullname', 20)->nullable();
				$table->string('kananame', 20)->nullable();
				$table->string('email')->nullable();
				$table->string('contact_phonenumber', 13)->nullable();
				$table->string('employee_code', 10)->nullable();
				$table->string('sex', 10)->nullable();
				$table->date('dateofbirth')->nullable();
				$table->date('dateofjoining')->nullable();
				$table->date('retirementdate')->nullable();
				$table->string('remarks')->nullable();
				$table->string('password')->nullable();
				$table->string('account_status', 30)->nullable();
				$table->date('password_expiration')->nullable();
				$table->integer('numberofincorrect_passwords')->nullable();
				$table->timestamp('account_lock_datetime')->nullable();
				for ($attribute = 1; $attribute <= 5; $attribute++) {
					$table->string(sprintf('employee_attribute%02d', $attribute))->nullable();
				}
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('employee_affiliation_information')) {
			Schema::create('employee_affiliation_information', function (Blueprint $table) {
				$table->increments('eai_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->unsignedInteger('employee_id');
				$table->integer('affiliation_code');
				$table->unsignedInteger('job_id');
				$table->date('application_startdate')->nullable();
				$table->date('enddate_of_application')->nullable();
				$table->char('system_administrator_privileges', 1)->nullable();
				$table->char('employee_registration_authority', 1)->nullable();
				$table->char('course_enrollment_privileges', 1)->nullable();
				$table->char('attendance_setting_authority', 1)->nullable();
				$table->char('authority_validity_scope', 1)->nullable();
				$table->string('authority_validity_code', 9)->nullable();
				$table->softDeletes();
				$table->foreign('employee_id')->references('employee_id')->on('employee_information');
				$table->foreign('affiliation_code')->references('affiliation_code')->on('affiliation_information');
				$table->foreign('job_id')->references('job_id')->on('job_information');
			});
		}

		if (!Schema::hasTable('course_classification_information')) {
			Schema::create('course_classification_information', function (Blueprint $table) {
				$table->increments('course_classification_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->string('course_classification_name', 10)->nullable();
				$table->string('icon_file_path')->nullable();
				$table->string('displayorder', 3)->nullable();
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('course_classification_detail_information')) {
			Schema::create('course_classification_detail_information', function (Blueprint $table) {
				$table->increments('course_classification_details_id');
				$table->unsignedInteger('course_classification_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->string('course_classification_detailsname')->nullable();
				$table->string('icon_file_path')->nullable();
				$table->string('display_order', 3)->nullable();
				$table->softDeletes();
				$table->foreign('course_classification_id')->references('course_classification_id')->on('course_classification_information');
			});
		}

		if (!Schema::hasTable('course_information')) {
			Schema::create('course_information', function (Blueprint $table) {
				$table->increments('course_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->unsignedInteger('course_classification_id');
				$table->unsignedInteger('course_classification_details_id');
				$table->string('coursename', 30);
				$table->string('coursename_kana', 30);
				$table->text('course_description')->nullable();
				$table->char('possible_retake_course_deadline', 3)->nullable();
				$table->string('remarks');
				$table->char('todo_type', 3)->nullable();
				$table->text('todo_description')->nullable();
				$table->char('repeated_retest', 3)->nullable();
				$table->decimal('test_passed_score', 6, 0);
				for ($attribute = 1; $attribute <= 5; $attribute++) {
					$table->string(sprintf('course_attributes_%02d', $attribute));
				}
				$table->softDeletes();
				$table->foreign('course_classification_id')->references('course_classification_id')->on('course_classification_information');
				$table->foreign('course_classification_details_id')->references('course_classification_details_id')->on('course_classification_detail_information');
			});
		}

		if (!Schema::hasTable('course_material_information')) {
			Schema::create('course_material_information', function (Blueprint $table) {
				$table->increments('material_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->unsignedInteger('course_id');
				$table->string('display_order', 3);
				$table->string('teaching_material_name', 20);
				$table->char('material_type', 2)->nullable();
				$table->string('youtube_video_url')->nullable();
				$table->string('book_file_path')->nullable();
				$table->softDeletes();
				$table->foreign('course_id')->references('course_id')->on('course_information');
			});
		}

		if (!Schema::hasTable('course_attribute_setting_information')) {
			Schema::create('course_attribute_setting_information', function (Blueprint $table) {
				$table->increments('casi_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				for ($attribute = 1; $attribute <= 4; $attribute++) {
					$prefix = sprintf('course_attribute%02d_', $attribute);
					$table->string($prefix . 'displayname', 20)->nullable();
					$table->string($prefix . 'displayrank', 3)->nullable();
					$table->char($prefix . 'screentype', 1)->nullable();
					$table->decimal($prefix . 'numberofscreen_digits', 3, 0)->nullable();
					$table->char($prefix . 'attendance_selection', 1)->nullable();
				}
				$table->string('course_attribute05_displayname', 20)->nullable();
				$table->string('course_attribute05_displayrank', 3)->nullable();
				$table->char('course_attribute05_screentype', 1)->nullable();
				$table->decimal('course_attribute05_screen_columncount', 3, 0)->nullable();
				$table->char('course_attributes05_enrollment_selection', 1)->nullable();
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('course_attribute_pulldown_settings')) {
			Schema::create('course_attribute_pulldown_settings', function (Blueprint $table) {
				$table->increments('capsi_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->decimal('course_attribute_number', 2, 0)->nullable();
				for ($option = 1; $option <= 10; $option++) {
					$table->string('pulldown_list_' . $option, 20)->nullable();
				}
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('course_schedule_results_information')) {
			Schema::create('course_schedule_results_information', function (Blueprint $table) {
				$table->increments('attendance_setting_id');
				$table->unsignedInteger('course_id');
				$table->unsignedInteger('employee_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->timestamp('schedule_course')->nullable();
				$table->timestamp('course_information')->nullable();
				$table->date('deadline_enrollment')->nullable();
				$table->char('todo_progress', 3)->nullable();
				$table->timestamp('todo_complete')->nullable();
				$table->string('number_test_conducted', 3)->nullable();
				$table->string('first_test_correct_answer_rate', 6)->nullable();
				$table->string('latest_test_number_correct_answer', 3)->nullable();
				$table->string('latest_test_accuracy_rate', 6)->nullable();
				$table->unsignedInteger('first_test_number_correct_answer')->nullable();
				$table->softDeletes();
				$table->foreign('course_id')->references('course_id')->on('course_information');
				$table->foreign('employee_id')->references('employee_id')->on('employee_information');
			});
		}

		if (!Schema::hasTable('course_todo_item_information')) {
			Schema::create('course_todo_item_information', function (Blueprint $table) {
				$table->increments('todo_item_id');
				$table->unsignedInteger('course_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->string('display_order', 3);
				$table->string('question')->nullable();
				$table->char('answer_type', 3)->nullable();
				$table->char('required_settings', 3)->nullable();
				$table->text('test_explained')->nullable();
				$table->softDeletes();
				$table->foreign('course_id')->references('course_id')->on('course_information');
			});
		}

		if (!Schema::hasTable('course_todo_items_choice_information')) {
			Schema::create('course_todo_items_choice_information', function (Blueprint $table) {
				$table->increments('todo_option_id');
				$table->unsignedInteger('todo_items_id');
				$table->unsignedInteger('course_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->string('display_order', 3)->nullable();
				$table->string('choices', 50)->nullable();
				$table->char('test_choice_correct_answer', 1)->nullable();
				$table->softDeletes();
				$table->foreign('todo_items_id')->references('todo_item_id')->on('course_todo_item_information');
				$table->foreign('course_id')->references('course_id')->on('course_information');
			});
		}

		if (!Schema::hasTable('attendance_todo_item_answer_information')) {
			Schema::create('attendance_todo_item_answer_information', function (Blueprint $table) {
				$table->increments('atiai_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->unsignedInteger('employee_id');
				$table->unsignedInteger('course_id');
				$table->unsignedInteger('attendance_settings_id');
				$table->unsignedInteger('todo_items_id');
				$table->text('text_answer')->nullable();
				$table->text('report')->nullable();
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('attendance_todo_answer_selection_information')) {
			Schema::create('attendance_todo_answer_selection_information', function (Blueprint $table) {
				$table->increments('atiasi_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->unsignedInteger('employee_id');
				$table->unsignedInteger('course_id');
				$table->unsignedInteger('attendance_setting_id');
				$table->unsignedInteger('todo_items_id');
				$table->unsignedInteger('todo_option_id');
				$table->char('selection', 3)->nullable();
				$table->string('other_text_answer');
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('employee_attribute_setting_information')) {
			Schema::create('employee_attribute_setting_information', function (Blueprint $table) {
				$table->increments('easi_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				for ($attribute = 1; $attribute <= 3; $attribute++) {
					$prefix = sprintf('employee_attribute%02d_', $attribute);
					$table->string($prefix . 'displayname', 20)->nullable();
					$table->char($prefix . 'displayorder', 3)->nullable();
					$table->string($prefix . 'screentype', 20)->nullable();
					$table->decimal($prefix . 'screencolumn_count', 3, 0)->nullable();
					$table->char($prefix . 'courseselection', 3)->nullable();
				}
				for ($attribute = 4; $attribute <= 5; $attribute++) {
					$prefix = sprintf('employee_attribute%02d_', $attribute);
					$table->string($prefix . 'displayname', 20)->nullable();
					$table->char($prefix . 'displayrank', 3)->nullable();
					$table->string($prefix . 'screentype', 20)->nullable();
					$table->decimal($prefix . 'screencolumn_count', 3, 0)->nullable();
					$table->char($prefix . ($attribute === 4 ? 'attendance_selection' : 'courseselection'), 3)->nullable();
				}
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('employee_attribute_dropdown_settings_information')) {
			Schema::create('employee_attribute_dropdown_settings_information', function (Blueprint $table) {
				$table->increments('eadsi_id');
				$table->foreignId('company_id')->constrained('company_information', 'company_id');
				$table->decimal('employee_attribute_number', 2, 0)->nullable();
				for ($option = 1; $option <= 10; $option++) {
					$table->string('pulldown_list_' . $option, 20)->nullable();
				}
				$table->softDeletes();
			});
		}

		if (!Schema::hasTable('questionnaire')) {
			Schema::create('questionnaire', function (Blueprint $table) {
				$table->increments('id');
				$table->string('question_text');
				$table->string('answer_type', 20);
				$table->boolean('is_required');
				$table->softDeletes();
			});
		}

		// Match the timestamp columns provided by the legacy timestamp migration.
		foreach ([
			'affiliation_information',
			'attendance_todo_answer_selection_information',
			'attendance_todo_item_answer_information',
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
		] as $tableName) {
			if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'created_at')) {
				Schema::table($tableName, function (Blueprint $table) {
					$table->timestamps();
				});
			}
		}
	}

	public function down(): void
	{
		// Intentionally retain these application tables and any data on rollback.
	}
};
