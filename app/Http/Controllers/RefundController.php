<?php

namespace App\Http\Controllers;

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
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        if(Auth::user()->user_type == "admin")
        {
            $refund_request = RefundRequest::orderBy('id', 'desc')
            ->distinct();
            $refund_request = $refund_request->paginate(15);
            return view('admin.refund_request.index',compact('refund_request'));
        }
        else
        {
            $refund_request = RefundRequest::orderBy('id', 'desc')
            ->where('buyer_id',Auth::user()->id)
            ->distinct();
            $refund_request = $refund_request->paginate(15);
            return view('user_layout.refund_request.index',compact('refund_request'));
        }

        
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
    public function store(Request $request)
    {
        // dd($request->all());
        $refund_request = new RefundRequest();
        $refund_request->code = date('Ymd-His') . rand(10, 99);
        $refund_request->order_detail_id = $request->order_detail_id;
        $refund_request->buyer_id = Auth::user()->id;
        $refund_request->price = $request->price;
        $refund_request->shipping_price = $request->shipping_price;
        $refund_request->reason = $request->reason;
        $refund_request->status = 0;
        // $refund_request->photos = implode(',', $request->photos);
        $refund_request->save();
        flash(translate('Refund request has been submitted successfully'))->success();
        return back();
    }


    public function approve(Request $request)
    {
        // dd($request->all());
        $refund_request = RefundRequest::find($request->id_request);
        $refund_request->status = 1;
        $user = User::find($refund_request->buyer_id);
        Notification::send($user, new RefundNotification($refund_request));
        // $refund_request->photos = implode(',', $request->photos);
        $refund_request->save();
    }

    public function reject(Request $request)
    {
        // dd($request->all());
        $refund_request = RefundRequest::find($request->id_request);
        $user = User::find($refund_request->buyer_id);
        $refund_request->status = 99;
        $refund_request->save();
        Notification::send($user, new RefundNotification($refund_request));
        
    }

    public function refund_success(Request $request)
    {
        // dd($request->all());
        $refund_request = RefundRequest::find($request->id_request);
        $user = User::find($refund_request->buyer_id);
        $refund_request->img_proof = $request->proof_image;
        $refund_request->status = 2;
        $refund_request->save();
        Notification::send($user, new RefundNotification($refund_request));
        flash(translate('Request has been refunded successfully'))->success();
        return back();
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refund_request = RefundRequest::find($id);
        $order_detail = OrderDetail::find($refund_request->order_detail_id);
        $order = $order_detail->order;
        if(Auth::user()->user_type == "admin")
        {
            return view('admin.refund_request.detail',compact('refund_request','order_detail','order'));
        }
        else
        {
            return view('user_layout.refund_request.detail',compact('refund_request','order_detail','order'));
        }
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
