<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('seller.products.index');
    }

    public function create()
    {
        return view('seller.products.create');
    }
}
