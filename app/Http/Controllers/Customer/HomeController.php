<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $best_selling_products = Products::all()->take(4);
        $fresh_today_products = Products::all()->take(3);
        $new_products = Products::latest()->limit(8)->get();
        return view('user_layout.index',['best_selling_products'=>$best_selling_products,'fresh_today_products'=>$fresh_today_products,'new_products'=>$new_products]);
    }
}
