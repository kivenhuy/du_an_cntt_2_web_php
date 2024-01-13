<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Products;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $best_selling_products = Products::where('approved',1)->get()->take(4);
        $fresh_today_products = Products::where('approved',1)->where('short_shelf_life',1)->get()->take(3);
        $new_products = Products::where('approved',1)->latest()->limit(8)->get();
        return view('user_layout.index',['best_selling_products'=>$best_selling_products,'fresh_today_products'=>$fresh_today_products,'new_products'=>$new_products]);
    }

    public function product(Request $request, $slug)
    {
       

        $detailedProduct  = Products::where('slug', $slug)->where('approved', 1)->first();
        $categories_data = Categories::find($detailedProduct->category_id);
        if ($detailedProduct != null && $detailedProduct->published) {
            $data_product = json_decode($detailedProduct->choice_options);
            
            $arr_attr = [];
           
            $review_status = 0;
           
            return view('user_layout.products.product_detail',
                [
                'detailedProduct' => $detailedProduct,
                // 'product_queries' => $product_queries,
                // 'total_query' => $total_query,
                // 'reviews' => $reviews,
                'review_status' => $review_status,
                'arr_attr' => $arr_attr,
                'categories_data'=>$categories_data,
                // 'order_sample'=>$order_sample,
                'product_traceability'=>0,
            ]);
        }
    }

    public function comming_soon()
    {
        return view('user_layout.comming_soon');
    }

    public function dashboard()
    {
        if (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'enterprise' ) 
        {
            return view('user_layout.dashboard');
        } else {
            abort(404);
        }
    }
}
