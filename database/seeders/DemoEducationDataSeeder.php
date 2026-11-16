<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoEducationDataSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('company_information')->where('company_name', 'Demo Education Co')->value('company_id');
        if (!$companyId) {
            DB::table('company_information')->insert([
                'company_name' => 'Demo Education Co',
                'login_screen_url' => 'http://127.0.0.1:8000/login/demo-education',
                'icon_storage_file_path' => 'img/officewill.png',
                'teaching_material_storage_file_path' => 'storage/demo-education/materials',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $companyId = DB::table('company_information')->where('company_name', 'Demo Education Co')->value('company_id');
        }

        $affiliationCode = 99001;
        DB::table('affiliation_information')->updateOrInsert(
            ['affiliation_code' => $affiliationCode],
            ['company_id' => $companyId, 'affiliation_name' => 'Demo Education Office', 'display_order' => '001', 'organization_type' => 'Main store equivalent']
        );

        $jobs = [];
        foreach (['Admin', 'Employee', 'Teacher'] as $title) {
            $jobs[$title] = DB::table('job_information')->where('company_id', $companyId)->where('job_title', $title)->value('job_id');
            if (!$jobs[$title]) {
                DB::table('job_information')->insert([
                    'company_id' => $companyId,
                    'job_title' => $title,
                    'display_order' => '001',
                ]);
                $jobs[$title] = DB::table('job_information')->where('company_id', $companyId)->where('job_title', $title)->value('job_id');
            }
        }

        $employees = [
            ['code' => 'DEMO-ADM', 'name' => 'Demo Administrator', 'email' => 'demo.admin@example.test', 'job' => 'Admin', 'permissions' => [1, 1, 1, 1]],
            ['code' => 'DEMO-EMP', 'name' => 'Demo Employee', 'email' => 'demo.employee@example.test', 'job' => 'Employee', 'permissions' => [0, 1, 0, 0]],
            ['code' => 'DEMO-TCH', 'name' => 'Demo Teacher', 'email' => 'demo.teacher@example.test', 'job' => 'Teacher', 'permissions' => [0, 0, 1, 1]],
        ];

        foreach ($employees as $data) {
            $employeeId = DB::table('employee_information')->where('email', $data['email'])->value('employee_id');
            $employee = [
                'company_id' => $companyId, 'fullname' => $data['name'], 'kananame' => $data['name'],
                'email' => $data['email'], 'employee_code' => $data['code'], 'sex' => 'other',
                'dateofjoining' => '2026-01-01', 'password' => Hash::make('password'),
                'account_status' => 'enabled', 'numberofincorrect_passwords' => 0,
            ];
            if ($employeeId) {
                DB::table('employee_information')->where('employee_id', $employeeId)->update($employee);
            } else {
                DB::table('employee_information')->insert($employee);
                $employeeId = DB::table('employee_information')->where('email', $data['email'])->value('employee_id');
            }

            DB::table('employee_affiliation_information')->updateOrInsert(
                ['employee_id' => $employeeId],
                [
                    'company_id' => $companyId, 'affiliation_code' => $affiliationCode, 'job_id' => $jobs[$data['job']],
                    'application_startdate' => '2026-01-01', 'system_administrator_privileges' => $data['permissions'][0],
                    'employee_registration_authority' => $data['permissions'][1], 'course_enrollment_privileges' => $data['permissions'][2],
                    'attendance_setting_authority' => $data['permissions'][3], 'authority_validity_scope' => '1',
                    'authority_validity_code' => (string) $affiliationCode,
                ]
            );
        }

        $classificationName = 'Demo';
        $classificationId = DB::table('course_classification_information')->where('company_id', $companyId)->where('course_classification_name', $classificationName)->value('course_classification_id');
        if (!$classificationId) {
            DB::table('course_classification_information')->insert([
                'company_id' => $companyId, 'course_classification_name' => $classificationName, 'displayorder' => '001',
            ]);
            $classificationId = DB::table('course_classification_information')->where('company_id', $companyId)->where('course_classification_name', $classificationName)->value('course_classification_id');
        }
        $detailId = DB::table('course_classification_detail_information')->where('company_id', $companyId)->where('Course_classification_id', $classificationId)->value('course_classification_details_id');
        if (!$detailId) {
            DB::table('course_classification_detail_information')->insert([
                'Course_classification_id' => $classificationId, 'company_id' => $companyId,
                'course_classification_detailsname' => 'General Training', 'display_order' => '001',
            ]);
            $detailId = DB::table('course_classification_detail_information')->where('company_id', $companyId)->where('Course_classification_id', $classificationId)->value('course_classification_details_id');
        }

        foreach (['Orientation', 'Safety Basics', 'Customer Service', 'Leadership', 'Compliance'] as $index => $name) {
            DB::table('course_information')->updateOrInsert(
                ['company_id' => $companyId, 'coursename' => 'Demo ' . $name],
                [
                    'Course_classification_id' => $classificationId, 'course_classification_details_id' => $detailId,
                    'coursename_kana' => 'Demo ' . $name, 'course_description' => 'Demo education course.',
                    'remarks' => 'Seeded demo data', 'test_passed_score' => 70,
                    'course_attributes_01' => '', 'course_attributes_02' => '', 'course_attributes_03' => '',
                    'course_attributes_04' => '', 'course_attributes_05' => '',
                ]
            );
        }
    }
}
