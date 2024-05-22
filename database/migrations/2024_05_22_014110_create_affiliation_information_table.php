<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliationInformationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliation_information', function (Blueprint $table) {
            $table->string('affiliation_code')->primary();
            $table->unsignedBigInteger('company_id');
            $table->string('affiliation_name');
            $table->integer('display_order');
            $table->string('organization_type');
            $table->foreign('company_id')->references('company_id')->on('company_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliation_information');
    }
}
