<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\Review;
use App\Models\Uploads;
use Auth;
use DataTables;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $data_request = Order::with('orderDetails')->where('customer_id', $request->buyer_id)->orderBy('code', 'desc')->get();
        return response()->json([
            'result' => true,
            'data'=>$data_request,
        ]);
    }   

    

    public function get_detail($id)
    {
         
        $order = Order::find((int)($id))->append(['user_detail']);
        $order->delivery_viewed = 1;
        $order->save();
        
        $array_images = [];
        
        if(isset($order->manual_payment_data))
        {
           
            $data_manual = json_decode($order->manual_payment_data);
            $data_uploads = $data_manual->photo;
			if(isset($data_uploads))
            {
                if (str_contains($data_uploads, ',')) {
                    $data_uploads = explode(",", $data_uploads);
                    foreach($data_uploads as $data_photo)
                    {
                        $data_images = Uploads::findOrFail($data_photo);
                        array_push($array_images,$data_images->file_name);
                    }
                }
                else
                {
                    $data_uploads = $data_manual->photo;
                    $data_images = Uploads::findOrFail($data_uploads);
                    array_push($array_images,$data_images->file_name);
                }            
                
            }
            $order->img_url = $array_images;
            $order->name_payment = $data_manual->name;
            $order->amount_payment = $data_manual->amount;
            $order->trx_id = $data_manual->trx_id;
        } 
        return response()->json([
            'result' => true,
            'data'=>
            [
                'order'=>$order,
                'order_details'=>$order->orderDetails,
            ]
        ]);        
    }

    public function product_review_modal(Request $request){
        $product = Products::where('id',$request->product_id)->first();
        $review = Review::where('user_id',$request->ecom_id)->where('product_id',$product->id)->first();
        return response()->json([
            'result' => true,
            'data'=>
            [
                'product'=>$product,
                'review'=>$review,
            ]
        ]); 
    }

    public function store_review(Request $request)
    {
        $review = new Review;
        $review->product_id = $request->product_id;
        $review->user_id = $request->user_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->photos = "";
        $review->viewed = '0';
        $review->save();
        $product = Products::findOrFail($request->product_id);
        if(Review::where('product_id', $product->id)->where('status', 1)->count() > 0){
            $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating')/Review::where('product_id', $product->id)->where('status', 1)->count();
        }
        else {
            $product->rating = 0;
        }
        $product->save();

        // if($product->added_by == 'seller'){
        $seller = $product->user->shop;
        $seller->rating = (($seller->rating*$seller->num_of_reviews)+$review->rating)/($seller->num_of_reviews + 1);
        $seller->num_of_reviews += 1;
        $seller->save();
        // }
    }
    
}
