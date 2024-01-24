<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\CombineOrder;
use App\Models\Products;
use App\Models\RequestForProduct;
use Auth;
use Illuminate\Http\Request;
use Session;

class CheckoutController extends Controller
{
    // update_shipping_fee
    public function update_shipping_fee(Request $request)
    {
        if ($request->address_id == null) {
            flash(translate("Please add shipping address"))->warning();
            return back();
        }

        $carts = Cart::where([['user_id', Auth::user()->id],['is_checked',1]])->get();
        if($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        foreach ($carts as $cartItem) {
            $cartItem->address_id = $request->address_id;
            $cartItem->save();
        }
    }

    public function final_checkout()
    {
        if(Auth::user()->user_type != 'enterprise')
        {
            $carts_normal = Cart::whereHas('product', function ($query) {
                $query->where('short_shelf_life','=','0');
            })->where([['user_id', Auth::user()->id],['is_checked',1]])->get();
            $carts_short_shelf_life = Cart::whereHas('product', function ($query) {
                $query->where('short_shelf_life','=','1');
            })->where([['user_id', Auth::user()->id],['is_checked',1]])->get();
        }
        else
        {
            $carts_normal = Cart::whereHas('product', function ($query) {
                $query->where('short_shelf_life','=','0');
            })->where([['user_id', Auth::user()->id],['is_checked',1]])->get()->append(['shpping_date']);
            $carts_short_shelf_life = Cart::whereHas('product', function ($query) {
                $query->where('short_shelf_life','=','1');
            })->where([['user_id', Auth::user()->id],['is_checked',1]])->get()->append(['shpping_date']);
        }
        $seller_products = array();
        $seller_product_variation = array();
        $seller_products_normal = array();
        $seller_products_short = array();
        $discount = 0;
        foreach ($carts_normal as $key => $cartItem){
            $product = Products::find($cartItem['product_id']);
            $product_ids = array();
            if(isset($seller_products[$product->user_id])){
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem['product_id']);
            $seller_products_normal[$product->user_id] = $product_ids;
        }
        foreach ($carts_short_shelf_life as $key => $carts_short_shelf_lifeItem){
            $product = Products::find($carts_short_shelf_lifeItem['product_id']);
            $product_ids = array();
            if(isset($seller_products[$product->user_id])){
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $carts_short_shelf_lifeItem['product_id']);
            $seller_products_short[$product->user_id] = $product_ids;
        }
        $carrier_list = Carrier::all();
        // dd(gettype($carts_short_shelf_life));
        return view('user_layout.checkout.payment_select', compact('discount','carts_normal','carts_short_shelf_life','seller_products_normal','seller_products_short','carrier_list'));
    }

    public function update_total_shipping_fee(Request $request)
    {
        $user = Auth::user();
        $shipping_time = 1;
        if($user->user_type === "enterprise")
        {
            if($request->type_cart === "normal_product")
            {
                if($request->shipping_type === "weight_based")
                {
                    $shipping_type = 'Normal Shipping';
                }
                else
                {
                    $shipping_type = 'Fast Shipping';
                }
                $cart_data = Cart::whereHas('product', function ($query) {
                    $query->where('short_shelf_life','=','0');
                })->where([
                    ['user_id',$user->id],
                    ['owner_id',(int)$request->data_id_seller],
                    ['is_checked',1],
                    ['is_rfp','!=',0],
                ])->get();
                foreach ($cart_data as $each_cart_data)
                { 
                    $data_rfp = RequestForProduct::find($each_cart_data->is_rfp);
                    if(isset($data_rfp))
                    {
                        $shipping_time =count(json_decode(RequestForProduct::find($each_cart_data->is_rfp)->shipping_date));
                    }
                    $each_cart_data->update(
                        ['shipping_type' => $shipping_type,
                        'shipping_cost' => $request->total_shipping * $shipping_time,
                        'carrier_id'=>(int)$request->data_id
                        ]
                    );
                   
                }
            }
            else
            {
                $cart_data = Cart::whereHas('product', function ($query) {
                    $query->where('short_shelf_life','=','1');
                })->where([
                    ['user_id',$user->id],
                    ['owner_id',(int)$request->data_id_seller],
                    ['is_checked',1],
                    ['is_rfp','!=',0],
                ])->get();
                foreach ($cart_data as $each_cart_data)
                { 
                    $data_rfp = RequestForProduct::find($each_cart_data->is_rfp);
                    if(isset($data_rfp))
                    {
                        $shipping_time =count(json_decode(RequestForProduct::find($each_cart_data->is_rfp)->shipping_date));
                    }
                    $each_cart_data->update(
                        ['shipping_type' => 'Fast Shipping',
                        'shipping_cost' => $request->total_shipping * $shipping_time,
                        'carrier_id'=>(int)$request->data_id]
                    );
                }
            }
            $cart_shipping = Cart::where([
                ['user_id',$user->id],
                ['is_checked',1],
            ])->sum('shipping_cost');
            $total_price = $cart_shipping + $request->final_price;
        }
        else
        {
            if($request->type_cart === "normal_product")
            {
                if($request->shipping_type === "weight_based")
                {
                    $shipping_type = 'Normal Shipping';
                }
                else
                {
                    $shipping_type = 'Fast Shipping';
                }
                $cart_data = Cart::whereHas('product', function ($query) {
                    $query->where('short_shelf_life','=','0');
                })->where([
                    ['user_id',$user->id],
                    ['owner_id',(int)$request->data_id_seller],
                    ['is_checked',1],
                ])->update(
                    ['shipping_type' => $shipping_type,
                    'shipping_cost' => $request->total_shipping,
                    'carrier_id'=>(int)$request->data_id]
                );
            }
            else
            {
                $cart_data = Cart::whereHas('product', function ($query) {
                    $query->where('short_shelf_life','=','1');
                })->where([
                    ['user_id',$user->id],
                    ['owner_id',(int)$request->data_id_seller],
                    ['is_checked',1],
                ])->update(
                    ['shipping_type' => 'Fast Shipping',
                    'shipping_cost' => $request->total_shipping,
                    'carrier_id'=>(int)$request->data_id]
                );
            }
            $cart_shipping = Cart::where([
                ['user_id',$user->id],
                ['is_checked',1],
            ])->sum('shipping_cost');
            $total_price = $cart_shipping + $request->final_price;
        }
        
        return [
            'total_price' =>single_price($total_price),
            'shipping_price'=>  single_price($cart_shipping),
        ];
    }

    public function checkout(Request $request)
    {  
        if ($request->payment_option != null) {
            if(Auth::user()->user_type != "enterprise")
            {
                (new OrderController)->store($request);
            }
            else
            {
                (new OrderController)->store_enterprise($request);
            }
            

            $request->session()->put('payment_type', 'cart_payment');
            
            $data['combined_order_id'] = $request->session()->get('combined_order_id');
            $request->session()->put('payment_data', $data);

            if ($request->session()->get('combined_order_id') != null) 
            {                
                $combined_order = CombineOrder::findOrFail($request->session()->get('combined_order_id'));
                $manual_payment_data = array(
                    'name'   => $request->payment_option,
                    'amount' => $combined_order->grand_total,
                    'trx_id' => $request->trx_id,
                    'photo'  => $request->photo
                );
                foreach ($combined_order->orders as $order) {
                    $order->manual_payment = 1;
                    $order->manual_payment_data = json_encode($manual_payment_data);
                    $order->save();
                }
                //flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                return redirect()->route('order_confirmed');
            }
        } else {
            flash(translate('Select Payment Option.'))->warning();
            return back();
        }
    }

    public function order_confirmed()
    {
        $combined_order = CombineOrder::findOrFail(Session::get('combined_order_id'));

        // Cart::where('user_id', $combined_order->customer_id)->delete();

        return view('user_layout.checkout.order_confirmed', compact('combined_order'));
    }

}
