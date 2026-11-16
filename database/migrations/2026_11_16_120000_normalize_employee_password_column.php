<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
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
		} elseif ($hasEncryptedPassword) {
			DB::table('employee_information')
				->whereNull('password')
				->update(['password' => DB::raw('encrypted_password')]);
		}
	}

	public function down(): void
	{
		// Keep password hashes intact when rolling this compatibility migration back.
	}
};
