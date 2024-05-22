<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_information', function (Blueprint $table) {
            $table->id('employee_id');
            $table->unsignedBigInteger('company_id');
            $table->string('fullname');
            $table->string('kananame')->nullable();
            $table->string('email_address')->unique();
            $table->string('contact_phonenumber')->nullable();
            $table->string('employee_code')->unique();
            $table->string('sex');
            $table->date('dateofbirth');
            $table->date('dateofjoining');
            $table->date('retirementdate')->nullable();
            $table->string('remarks')->nullable();
            $table->string('encrypted_password');
            $table->string('account_status');
            $table->date('password_expiration')->nullable();
            $table->integer('numberofincorrect_passwords');
            $table->dateTime('account_lock_datetime')->nullable();
            $table->string('employee_attribute01')->nullable();
            $table->string('employee_attribute02')->nullable();
            $table->string('employee_attribute03')->nullable();
            $table->string('employee_attribute04')->nullable();
            $table->string('employee_attribute05')->nullable();
            $table->foreign('company_id')->references('company_id')->on('company_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_information');
    }
}
