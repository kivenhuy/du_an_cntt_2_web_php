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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('seller_id');
            $table->integer('product_id');
            $table->string('variation');
            $table->double('price',20,2);
            $table->double('shipping_cost',20,2);
            $table->integer('quantity');
            $table->string('payment_status')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('shipping_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
