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
		if (!Schema::hasTable('employee_information')
			|| !Schema::hasColumn('employee_information', 'email_address')
			|| Schema::hasColumn('employee_information', 'email')) {
			return;
		}

		Schema::table('employee_information', function (Blueprint $table) {
			$table->renameColumn('email_address', 'email');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		if (!Schema::hasTable('employee_information')
			|| !Schema::hasColumn('employee_information', 'email')
			|| Schema::hasColumn('employee_information', 'email_address')) {
			return;
		}

		Schema::table('employee_information', function (Blueprint $table) {
			$table->renameColumn('email', 'email_address');
		});
	}
};
