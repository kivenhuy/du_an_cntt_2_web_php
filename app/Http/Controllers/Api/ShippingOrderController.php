<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\ShippingHistory;
use App\Models\User;
use App\Notifications\OrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;

class ShippingOrderController extends Controller
{
    public function order_normal(){
        $order_details = OrderDetail::with('order')->orderByDesc('created_at')->where('shipping_date',null)->where('shipping_type','Normal Shipping')->get();
        return response()->json([
            'result' => true,
            'data'=>
            [
                'order_details'=>$order_details
            ]
        ]); 
    }

    public function order_fast(){
        $now = Carbon::now()->addHour(2);
        // dd($now);
        $order_details = OrderDetail::with('order')->orderByDesc('created_at')
        ->where('shipping_type','Fast Shipping')
        ->WhereDate('created_at','<=',$now)
        ->whereTime('created_at', '<=',$now->toTimeString())
        ->where('shipping_date',null)
        ->get();
        return response()->json([
            'result' => true,
            'data'=>
            [
                'order_details'=>$order_details
            ]
        ]); 
    }

    public function order_normal_enterprise(){
        $now = Carbon::now()->addHour(7);
        $order_details = OrderDetail::with('order')->orderByDesc('created_at')
        ->WhereDate('shipping_date','<=',$now)
        ->whereTime('shipping_date', '<=',$now->toTimeString())
        ->where('shipping_type','Normal Shipping')
        ->get();
        return response()->json([
            'result' => true,
            'data'=>
            [
                'order_details'=>$order_details
            ]
        ]); 
    }

    public function order_fast_enterprise(){
        $now = Carbon::now()->addHour(9);
        // dd($now);
        $order_details = OrderDetail::with('order')->orderByDesc('created_at')
        ->where('shipping_type','Fast Shipping')
        ->WhereDate('shipping_date','<=',$now)
        ->whereTime('shipping_date', '<=',$now->toTimeString())
        // ->where('shipping_date',null)
        ->get();
        return response()->json([
            'result' => true,
            'data'=>
            [
                'order_details'=>$order_details
            ]
        ]); 
    }

    public function order_detail($id){
        $order_details = OrderDetail::with('order')->find($id)->append(['shop_address']);
        $order_details->cus_email = User::find($order_details->order->customer_id)->email;
        $product_data = Products::find($order_details->product_id);
        $order_details->image_product = uploaded_asset($product_data->thumbnail_img);
        return response()->json([
            'result' => true,
            'data'=>
            [
                'order_details'=>$order_details
            ]
        ]); 
    }

    public function process_shipping_order(Request $request)
    {
        $order_details = OrderDetail::find($request->order_detail_id);
        if($request->status == "delivered")
        {
            $order_details->payment_status = "paid";
        }
        $order_details->delivery_status = $request->status;
        $order_details->save();
        if($order_details)
        {
            $shipping_history = new ShippingHistory();
            $shipping_history->order_detail_id = $request->order_detail_id;
            $shipping_history->shipper_id = $request->shipper_id;
            $shipping_history->shipper_name = $request->shipper_name;
            $shipping_history->photo = $request->photo;
            $shipping_history->status = $request->status;
            $shipping_history->save();
            if($shipping_history)
            {
                $customer = User::find($order_details->order->customer_id);
                Notification::send($customer, new OrderNotification($shipping_history));
                return response()->json([
                    'result' => true,
                    'status'=> true,
                ]); 
            }
            else
            {
                return response()->json([
                    'result' => false,
                    'status'=> false,
                ]); 
            }
        }
        return response()->json([
            'result' => false,
            'status'=> false,
        ]); 
    }
}
