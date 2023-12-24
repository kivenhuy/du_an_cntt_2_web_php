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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('address');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->integer('district_id');
            $table->string('lng')->nullable();
            $table->string('lat')->nullable();
            $table->string('postal_code');
            $table->string('phone');
            $table->integer('set_default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
