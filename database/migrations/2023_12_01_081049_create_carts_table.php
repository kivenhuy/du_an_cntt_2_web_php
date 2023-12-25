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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->integer('user_id');
            $table->integer('address_id')->nullable();
            $table->integer('product_id');
            $table->string('variation')->nullable();
            $table->double('price',20,2);
            $table->double('shipping_cost',20,2)->default(0);
            $table->string('shipping_type')->nullable();
            $table->integer('pickup_point')->nullable();
            $table->integer('carrier_id')->nullable();
            $table->double('discount',20,2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->integer('coupon_applied')->default(0);
            $table->integer('quantity');
            $table->integer('is_checked')->default(0);
            $table->integer('is_rfp')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
