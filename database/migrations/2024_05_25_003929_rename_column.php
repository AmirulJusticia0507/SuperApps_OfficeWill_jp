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
		if (!Schema::hasTable('job_information') || !Schema::hasColumn('job_information', 'Job_id')) {
			return;
		}

		Schema::table('job_information', function (Blueprint $table) {
			$table->renameColumn('Job_id', 'job_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		if (!Schema::hasTable('job_information') || !Schema::hasColumn('job_information', 'job_id')) {
			return;
		}

		Schema::table('job_information', function (Blueprint $table) {
			$table->renameColumn('job_id', 'Job_id');
		});
	}
};
