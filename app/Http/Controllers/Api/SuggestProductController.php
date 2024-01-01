<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductStock;
use App\Models\RequestForProduct;
use App\Models\User;
use Illuminate\Http\Request;

class SuggestProductController extends Controller
{
    public function suggest_for_supermarket()
    {
        $paddy_cate_products = Category::where('name','Paddy')->first()->product_stock->sortByDesc('qty')->take(10);
        $seafood_cate_products = Category::where('name','Seafood')->first()->product_stock->sortByDesc('qty')->take(10);
        $fresh_fruits_cate_products = Category::where('name','Fresh – Fruits')->first()->product_stock->sortByDesc('qty')->take(10);
        $products = ProductStock::all()->sortByDesc('qty')->take(10);
        $products_with_short_shelf_life = ProductStock::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','1');
        })->take(10)->get()->sortByDesc('qty')->values();
        $all_order = RequestForProduct::where('product_id','!=',0)->orderBy('quantity','desc')->take(20)->get();
        $productFomarts = []; 
        $productShortLifeFomarts = [];
        $productPaddyFomarts = [];
        $productSeafoodFomarts = [];
        $productFreshFruitsFomarts = [];
        $orderFormat = [];
        // All Product
        foreach ($products as $each_product) {
            
            $productFomarts[] = [
                $each_product->product_name,
                $each_product->qty,
            ];

        }

        // Short Shelf Life Products
        foreach ($products_with_short_shelf_life as $each_products_with_short_shelf_life) {
            
            $productShortLifeFomarts[] = [
                $each_products_with_short_shelf_life->product_name,
                $each_products_with_short_shelf_life->qty,
            ];

        }

        // Padddy Products
        foreach ($paddy_cate_products as $each_paddy_cate_products) {
            
            $productPaddyFomarts[] = [
                $each_paddy_cate_products->product_name,
                $each_paddy_cate_products->qty,
            ];

        }

        // SeaFood Products
        foreach ($seafood_cate_products as $each_seafood_cate_products) {
            
            $productSeafoodFomarts[] = [
                $each_seafood_cate_products->product_name,
                $each_seafood_cate_products->qty,
            ];

        }

         // Fresh Fruits Products
        foreach ($fresh_fruits_cate_products as $each_fresh_fruits_cate_products) {
            
            $productFreshFruitsFomarts[] = [
                $each_fresh_fruits_cate_products->product_name,
                $each_fresh_fruits_cate_products->qty,
            ];

        }

         // Top Order
        foreach ($all_order as $each_order) {
            
            $orderFormat[] = [
                $each_order->product_name,
                $each_order->quantity,
            ];

        }
        return response()->json([
            'result' => true,
            'data'=>[
                'product'=>$productFomarts,
                'products_with_short_shelf_life'=>$productShortLifeFomarts,
                'paddy_cate_products'=>$productPaddyFomarts,
                'seafood_cate_products'=>$productSeafoodFomarts,
                'fresh_fruits_cate_products'=>$productFreshFruitsFomarts,
                'all_order'=>$orderFormat,
            ]
        ]);
    }

    public function suggest_for_farm()
    {
        $all_order = RequestForProduct::where('product_id','!=',0)->orderBy('quantity','desc')->take(20)->get();
        // $top_super_market_order =  
        // Top Order
        foreach ($all_order as $each_order) {
            $buyer_name = User::find($each_order->buyer_id)->name;
            $orderFormat[] = [
                $each_order->product_name,
                $each_order->quantity,
            ];

        }
        return response()->json([
            'result' => true,
            'data'=>[
                'all_order'=>$orderFormat,
            ]
        ]);
    }
}
