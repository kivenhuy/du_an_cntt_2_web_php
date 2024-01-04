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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('combined_order_id');
            $table->integer('customer_id');
            $table->integer('seller_id')->nullable();
            $table->integer('carrier_id')->nullable();
            $table->integer('assign_delivery_boy')->nullable();
            $table->longText('shipping_address');
            $table->string('shipping_type')->nullable();
            $table->string('admin_approve_status')->default('approved');
            $table->string('delivery_status')->default('waiting');
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('manual_payment')->nullable();
            $table->longText('manual_payment_data')->nullable();
            $table->double('grand_total',20,2)->nullable();
            $table->string('code');
            $table->timestamp('order_date');
            $table->integer('viewed');
            $table->integer('delivery_viewed');
            $table->timestamp('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
