<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		foreach ([
			'course_classification_detail_information' => ['Course_classification_id' => 'course_classification_id'],
			'course_information' => ['Course_classification_id' => 'course_classification_id'],
			'course_material_information' => ['Course_id' => 'course_id'],
		] as $table => $columns) {
			if (!Schema::hasTable($table)) {
				continue;
			}

			foreach ($columns as $oldName => $newName) {
				if (Schema::hasColumn($table, $oldName) && !Schema::hasColumn($table, $newName)) {
					Schema::table($table, function ($blueprint) use ($oldName, $newName) {
						$blueprint->renameColumn($oldName, $newName);
					});
				}
			}
		}
	}

	public function down(): void
	{
		// Keep canonical column names so application data remains accessible.
	}
};
