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
        $fresh_fruits_cate_products = Category::where('name','Fresh - Fruits')->first()->product_stock->sortByDesc('qty')->take(10);
        $products = ProductStock::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','0');
        })->take(20)->get()->sortByDesc('qty')->values();
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
        $all_order = RequestForProduct::groupBy('product_name')->selectRaw('*, sum(quantity) as quantity')->orderBy('quantity','desc')->take(20)->get();
        $user_has_biggest_order = User::where('user_type','enterprise')->withCount('request_products')
        ->orderBy('request_products_count', 'desc')
        ->take(4)->get();
        $products = ProductStock::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','0');
        })->take(20)->get()->sortByDesc('qty')->values();
        $products_with_short_shelf_life = ProductStock::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','1');
        })->take(20)->get()->sortByDesc('qty')->values();
        $order_user_1=[];
        $order_user_2=[];
        $order_user_3=[];
        $order_user_4=[];
        $name_user_1=null;
        $name_user_2=null;
        $name_user_3=null;
        $name_user_4=null;
        $productFomarts = []; 
        $productShortLifeFomarts = [];
        if(isset($user_has_biggest_order[0]))
        {
            $data_request_user_1 = RequestForProduct::where('buyer_id',$user_has_biggest_order[0]->id)->groupBy('product_name')->selectRaw('*, sum(quantity) as quantity')->orderBy('quantity','desc')->take(20)->get();
            $name_user_1 = $user_has_biggest_order[0]->name;
            
            foreach($data_request_user_1 as $each_data_request)
            {
                $order_user_1[] = [
                    $each_data_request->product_name,
                    (int)$each_data_request->quantity,
                ];
            }
        }
        if(isset($user_has_biggest_order[1]))
        {
            $data_request_user_2 = RequestForProduct::where('buyer_id',$user_has_biggest_order[1]->id)->groupBy('product_name')->selectRaw('*, sum(quantity) as quantity')->orderBy('quantity','desc')->take(20)->get();
            $name_user_2 = $user_has_biggest_order[1]->name;
            foreach($data_request_user_2  as $each_data_request)
            {
                $order_user_2[] = [
                    $each_data_request->product_name,
                    (int)$each_data_request->quantity,
                ];
            }
        }
        if(isset($user_has_biggest_order[2]))
        {
            $data_request_user_3 = RequestForProduct::where('buyer_id',$user_has_biggest_order[2]->id)->groupBy('product_name')->selectRaw('*, sum(quantity) as quantity')->orderBy('quantity','desc')->take(20)->get();
            $name_user_3 = $user_has_biggest_order[2]->name;
            foreach($data_request_user_3 as $each_data_request)
            {
                $order_user_3[] = [
                    $each_data_request->product_name,
                    (int)$each_data_request->quantity,
                ];
            }
        }
        if(isset($user_has_biggest_order[3]))
        {
            $data_request_user_4 = RequestForProduct::where('buyer_id',$user_has_biggest_order[3]->id)->groupBy('product_name')->selectRaw('*, sum(quantity) as quantity')->orderBy('quantity','desc')->take(20)->get();
            $name_user_4 = $user_has_biggest_order[3]->name;
            foreach($data_request_user_4 as $each_data_request)
            {
                $order_user_4[] = [
                    $each_data_request->product_name,
                    (int)$each_data_request->quantity,
                ];
            }
        }
        foreach ($all_order as $each_order) {
            $orderFormat[] = [
                $each_order->product_name,
                (int)$each_order->quantity,
            ];

        }
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
        return response()->json([
            'result' => true,
            'data'=>[
                'all_order'=>$orderFormat,
                'product'=>$productFomarts,
                'products_with_short_shelf_life'=>$productShortLifeFomarts,
                'user_1'=>
                [
                    'name'=>$name_user_1,
                    'value'=>$order_user_1,
                ],
                'user_2'=>[
                    'name'=>$name_user_2,
                    'value'=>$order_user_2,
                ],
                'user_3'=>[
                    'name'=>$name_user_3,
                    'value'=>$order_user_3,
                ],
                'user_4'=>[
                    'name'=>$name_user_4,
                    'value'=>$order_user_4,
                ],
            ]
        ]);
    }
}
