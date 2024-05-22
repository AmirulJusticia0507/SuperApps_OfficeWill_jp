<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAffiliationInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_affiliation_information', function (Blueprint $table) {
            $table->id('eai_id');
            $table->unsignedBigInteger('company_id');
            $table->string('affiliation_code');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('employee_id');
            $table->date('application_startdate');
            $table->date('enddate_of_application');
            $table->boolean('system_administrator_privileges');
            $table->boolean('employee_registration_authority');
            $table->boolean('course_enrollment_privileges');
            $table->boolean('attendance_setting_authority');
            $table->string('authority_validity_scope');
            $table->string('authority_validity_code');
            $table->foreign('company_id')->references('company_id')->on('company_information');
            $table->foreign('affiliation_code')->references('affiliation_code')->on('affiliation_information');
            $table->foreign('job_id')->references('job_id')->on('job_information');
            $table->foreign('employee_id')->references('employee_id')->on('employee_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_affiliation_information');
    }
}
