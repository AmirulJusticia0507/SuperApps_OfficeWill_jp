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
		$this->normalizePasswordColumn();
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		if (Schema::hasTable('employee_information')
			&& Schema::hasColumn('employee_information', 'password')
			&& !Schema::hasColumn('employee_information', 'encrypted_password')) {
			Schema::table('employee_information', function (Blueprint $table) {
				$table->renameColumn('password', 'encrypted_password');
			});
		}
	}

	private function normalizePasswordColumn(): void
	{
		if (!Schema::hasTable('employee_information')) {
			return;
		}

		$hasPassword = Schema::hasColumn('employee_information', 'password');
		$hasEncryptedPassword = Schema::hasColumn('employee_information', 'encrypted_password');

		if ($hasEncryptedPassword && !$hasPassword) {
			Schema::table('employee_information', function (Blueprint $table) {
				$table->renameColumn('encrypted_password', 'password');
			});
		} elseif (!$hasPassword) {
			Schema::table('employee_information', function (Blueprint $table) {
				$table->string('password')->nullable();
			});
		}
	}
};
