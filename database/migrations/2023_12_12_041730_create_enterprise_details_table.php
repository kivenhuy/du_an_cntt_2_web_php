<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enterprise_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('bussiness_name');
            $table->string('organization_type');
            $table->string('business_type');
            $table->string('fax_number');
            $table->string('tax_number');
            $table->string('regis_number');
            $table->timestamp('date_of_regis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprise_details');
    }
};
