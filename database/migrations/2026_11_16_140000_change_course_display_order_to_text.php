<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('course_classification_information') && Schema::hasColumn('course_classification_information', 'displayorder')) {
            Schema::table('course_classification_information', function (Blueprint $table): void {
                $table->text('displayorder')->change();
            });
        }

        if (Schema::hasTable('course_classification_detail_information') && Schema::hasColumn('course_classification_detail_information', 'display_order')) {
            Schema::table('course_classification_detail_information', function (Blueprint $table): void {
                $table->text('display_order')->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('course_classification_information') && Schema::hasColumn('course_classification_information', 'displayorder')) {
            Schema::table('course_classification_information', function (Blueprint $table): void {
                $table->string('displayorder', 3)->change();
            });
        }

        if (Schema::hasTable('course_classification_detail_information') && Schema::hasColumn('course_classification_detail_information', 'display_order')) {
            Schema::table('course_classification_detail_information', function (Blueprint $table): void {
                $table->string('display_order', 3)->change();
            });
        }
    }
};
