<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyCourseClassificationSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('company_information')->orderBy('company_id')->value('company_id');

        if (!$companyId) {
            $this->command?->warn('Skipped course classification seed: no company exists.');
            return;
        }

        $classificationId = DB::table('course_classification_information')
            ->where('company_id', $companyId)
            ->where('course_classification_name', 'common')
            ->value('course_classification_id');

        if (!$classificationId) {
            $classificationId = DB::table('course_classification_information')->insertGetId([
                'company_id' => $companyId,
                'course_classification_name' => 'common',
                'icon_file_path' => null,
                'displayorder' => '010',
            ], 'course_classification_id');
        }

        DB::table('course_classification_detail_information')->updateOrInsert(
            [
                'company_id' => $companyId,
                'Course_classification_id' => $classificationId,
                'course_classification_detailsname' => 'Chiropractic/Body care',
            ],
            [
                'icon_file_path' => null,
                'display_order' => '060',
            ]
        );
    }
}
