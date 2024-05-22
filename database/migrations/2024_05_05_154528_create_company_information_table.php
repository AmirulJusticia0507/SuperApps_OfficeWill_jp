<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_information', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('company_name', 20);
            $table->string('login_screen_url', 255);
            $table->string('icon_storage_file_path', 255);
            $table->string('teaching_material_storage_file_path', 255);
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('company_id')->references('id')->on('company_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_information');
    }
}
