<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
            'name'=>'Product 01',
            'user_id'=>3,
            'category_id'=>1,
            'photos'=>"",
            'thumbnail_img'=>"",
            'tags'=>0,
            'description'=>"",
            'unit_price'=>48000,
            'purchase_price'=>0.00,
            'variant_product'=>0,
            'attributes'=>"[]",
            'choice_options'=>"[]",
            'approved'=>0,
            'current_stock'=>30000,
            'unit'=>"KG",
            'weight'=>0.05,
            'min_qty'=>1,
            'low_stock_quantity'=>1,
            'discount'=>0.00,
            'discount_type'=>"amount",
            'discount_start_date'=>"",
            'discount_end_date'=>"",
            'shipping_type'=>"free",
            'est_shipping_days'=>2,
            'num_of_sale'=>0,
            'meta_img'=>"Product 01",
            'slug'=>"product_01",
            'rating'=>0.00,
        ]);
    }
}
