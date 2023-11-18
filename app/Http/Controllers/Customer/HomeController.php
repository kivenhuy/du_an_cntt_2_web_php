<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $best_selling_products = Products::all();
        return view('user_layout.index',['best_selling_products'=>$best_selling_products]);
    }
}
