<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\RefundRequest;
use App\Models\Review;
use App\Models\ShippingHistory;
use App\Models\User;
use App\Notifications\RefundNotification;
use App\Notifications\WelcomeNotification;
use Auth;
use Illuminate\Http\Request;
use Notification;

class RefundController extends Controller
{
    public function __construct() {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $refund_request = RefundRequest::with('order_detail')->orderBy('id', 'desc')
        ->where('buyer_id',$request->buyer_id)
        ->get();
        return response()->json([
            'result' => true,
            'data'=>$refund_request
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refund_request = RefundRequest::find($id)->append(['img_refund']);
        $order_detail = OrderDetail::find($refund_request->order_detail_id);
        $order = Order::find($order_detail->order->id)->append(['user_detail']);
        return response()->json([
            'result' => true,
            'data'=>[
                'refund_request'=>$refund_request,
                'order'=>$order,
                'order_detail'=>$order_detail,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatePublished(Request $request)
    {
        $review = Review::findOrFail($request->id);
        $review->status = $request->status;
        $review->save();

        $product = Products::findOrFail($review->product->id);
        if(Review::where('product_id', $product->id)->where('status', 1)->count() > 0){
            $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating')/Review::where('product_id', $product->id)->where('status', 1)->count();
        }
        else {
            $product->rating = 0;
        }
        $product->save();

        if($product->added_by == 'seller'){
            $seller = $product->user->shop;
            if ($review->status) {
                $seller->rating = (($seller->rating*$seller->num_of_reviews)+$review->rating)/($seller->num_of_reviews + 1);
                $seller->num_of_reviews += 1;
            }
            else {
                $seller->rating = (($seller->rating*$seller->num_of_reviews)-$review->rating)/max(1, $seller->num_of_reviews - 1);
                $seller->num_of_reviews -= 1;
            }

            $seller->save();
        }

        return 1;
    }

    public function product_review_modal(Request $request){
        $product = Products::where('id',$request->product_id)->first();
        $review = Review::where('user_id',Auth::user()->id)->where('product_id',$product->id)->first();
        return view('user_layout.partials.product_review_modal', compact('product','review'));
    }

    public function shipping_history(Request $request){
        $shipping_history = ShippingHistory::orderByDesc('created_at')->where('order_detail_id',$request->order_detail_id)->get();
        // dd(OrderDetail::find($shipping_history[0]->order_detail_id));
        return view('user_layout.partials.shipping_history', compact('shipping_history'));
    }


}
