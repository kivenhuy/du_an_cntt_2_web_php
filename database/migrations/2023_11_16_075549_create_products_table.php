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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->string('photos')->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->string('tags')->nullable();
            $table->longText('description')->nullable();
            $table->double('unit_price',20,2);
            $table->double('purchase_price',20,2)->nullable();
            $table->integer('variant_product')->nullable();
            $table->string('attributes')->nullable();
            $table->longText('choice_options');
            $table->integer('approved')->default(0);
            $table->integer('current_stock');
            $table->integer('short_shelf_life')->default(0);
            $table->string('unit');
            $table->double('weight',8,2);
            $table->integer('min_qty');
            $table->integer('published');
            $table->integer('low_stock_quantity')->nullable();
            $table->double('discount',20,2)->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->string('shipping_type')->nullable();
            $table->integer('est_shipping_days')->nullable();
            $table->integer('num_of_sale')->default(0);
            $table->integer('short_shelf_life')->default(0);
            $table->string('meta_img')->nullable();
            $table->mediumText('slug');
            $table->double('rating', 8, 2)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
