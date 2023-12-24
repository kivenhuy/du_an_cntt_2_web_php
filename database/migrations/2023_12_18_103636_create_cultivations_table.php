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
        Schema::connection('mysql_second')->create('cultivations', function (Blueprint $table) {
            $table->id();
            $table->integer('farmer_id');
            $table->string('cultivation_name');
            $table->string('harvest_Season');
            $table->string('crop_variety');
            $table->timestamps('sowing_Date');
            $table->timestamps('expected_Date_of_Harvest_after_Sowing');
            $table->string('est_Yield');
            $table->string('seed_Quantity_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultivations');
    }
};
