<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

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
            // $product_queries = ProductQuery::where('product_id', $detailedProduct->id)->where('customer_id', '!=', Auth::id())->latest('id')->paginate(3);
            // $total_query = ProductQuery::where('product_id', $detailedProduct->id)->count();
            // $reviews = $detailedProduct->reviews()->paginate(3);
            // // Pagination using Ajax
            // if (request()->ajax()) {
            //     if ($request->type == 'query') {
            //         return Response::json(View::make('frontend.partials.product_query_pagination', array('product_queries' => $product_queries))->render());
            //     }
            //     if ($request->type == 'review') {
            //         return Response::json(View::make('frontend.product_details.reviews', array('reviews' => $reviews))->render());
            //     }
            // }

            // review status
            $review_status = 0;
            // if (Auth::check()) {
            //     $OrderDetail = OrderDetail::with(['order' => function ($q) {
            //         $q->where('user_id', Auth::id());
            //     }])->where('product_id', $detailedProduct->id)->where('delivery_status', 'delivered')->first();
            //     $review_status = $OrderDetail ? 1 : 0;
            // }
            // return view('frontend.product_details', compact('data_attribute', 'values', 'detailedProduct', 'product_queries', 'total_query', 'reviews', 'review_status'));
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
}
