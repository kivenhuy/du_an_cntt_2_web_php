<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class RecomendationController extends Controller
{
    public function index()
    {
        $fresh_fruit_high_quantity = Products::where('approved',1)
        ->withCount('order_detail')
        ->orderBy('order_detail_count', 'asc')
        ->get()->append(['percent_date'])->sortBy('percent_date')->filter(function ($item) {
            return  $item->percent_date <= 60 && $item->percent_date > 0;
        })->values()->take(8);

        $count_enteprise = User::where('user_type','enterprise')->count();
        // dd($count_enteprise);
        return view('user_layout.recommendation.index',compact('fresh_fruit_high_quantity','count_enteprise'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $product = Products::find((int)$request->product_id);
        // dd($product);
        $quantity =  str_replace(' KG', '', $request->quantity);
        $quantity = (int)$quantity;
        return view('user_layout.recommendation.create',compact('product','quantity'));
    }
}
