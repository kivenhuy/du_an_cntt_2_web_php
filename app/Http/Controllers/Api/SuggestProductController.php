<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class SuggestProductController extends Controller
{
    public function suggest_for_supermarket()
    {
        $products = ProductStock::all()->sortByDesc('qty')->take(10)->append('product_name');
        $products_with_short_shelf_life = ProductStock::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','1');
        })->get()->sortByDesc('qty')->values()->take(10)->append('product_name');
        // $products_with_short_shelf_life = Products::where('short_shelf_life',1)->with('product_stock')->get()->pluck('product_stock')->sortByDesc('qty')->values()->take(10);
        $productFomarts = [];
        $productShortLifeFomarts = [];
        foreach ($products as $each_product) {
            
            $productFomarts[] = [
                $each_product->product_name,
                $each_product->qty,
            ];

        }
        foreach ($products_with_short_shelf_life as $each_products_with_short_shelf_life) {
            
            $productShortLifeFomarts[] = [
                $each_products_with_short_shelf_life->product_name,
                $each_products_with_short_shelf_life->qty,
            ];

        }
        return response()->json([
            'result' => true,
            'data'=>[
                'product'=>$productFomarts,
                'products_with_short_shelf_life'=>$productShortLifeFomarts,
            ]
        ]);
    }
}
