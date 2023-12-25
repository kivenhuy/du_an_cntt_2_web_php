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
        Schema::create('request_for_products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('code');
            $table->integer('shop_id');
            $table->integer('buyer_id');
            $table->timestamp('from_date');
            $table->timestamp('to_date');
            $table->longText('shipping_date');
            $table->string('distance_between_shipping_date');
            $table->integer('quantity');
            $table->string('unit');
            $table->double('price',8,2)->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_for_products');
    }
};