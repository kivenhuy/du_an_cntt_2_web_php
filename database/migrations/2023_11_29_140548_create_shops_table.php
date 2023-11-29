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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->longText('slider')->nullable();
            $table->string('top_banner')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->double('rating',8,2)->nullable();
            $table->integer('num_of_reviews')->nullable();
            $table->integer('num_of_sale')->nullable();
            $table->integer('verification_status')->nullable();
            $table->longText('verification_info')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('pick_up_point_id')->nullable();
            $table->double('shipping_cost',8,2)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_acc_name')->nullable();
            $table->string('bank_acc_no')->nullable();
            $table->string('slug')->nullable();
            $table->integer('bank_payment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
