<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CombineOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carts = Cart::where([['user_id', Auth::user()->id],['is_checked',1]])->get();

        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        $address = Address::where('id', $carts[0]['address_id'])->first();

        $shippingAddress = [];
        if ($address != null) {
            $shippingAddress['name']        = Auth::user()->name;
            $shippingAddress['email']       = Auth::user()->email;
            $shippingAddress['address']     = $address->address;
            $shippingAddress['country']     = $address->country->country_name;
            $shippingAddress['city']        = $address->city->city_name;
            $shippingAddress['district']    = $address->district->district_name;
            $shippingAddress['postal_code'] = $address->postal_code;
            $shippingAddress['phone']       = $address->phone;
        }

        // dd(json_encode($shippingAddress));
        $combined_order = new CombineOrder();
        $combined_order->customer_id = Auth::user()->id;
        $combined_order->shipping_address = json_encode($shippingAddress);
        $combined_order->save();

        $seller_products = array();
        foreach ($carts as $cartItem) {
            $product_ids = array();
            $product = Products::find($cartItem['product_id']);
            if (isset($seller_products[$product->user_id])) {
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem);
            $seller_products[$product->user_id] = $product_ids;
        }
       
        foreach ($seller_products as $seller_product) {
            $order = new Order;
            $order->combined_order_id = $combined_order->id;
            $order->customer_id = Auth::user()->id;
            $order->shipping_address = $combined_order->shipping_address;
            $order->payment_type = $request->payment_option;
            $order->payment_status = "unpaid";
            $order->delivery_viewed = 0;
            $order->viewed = 0;
            $order->code = date('Ymd-His') . rand(10, 99);
            $order->order_date = Carbon::now();
            $order->save();

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $coupon_discount = 0;

            
            //Order Details Storing
            foreach ($seller_product as $cartItem) {
                $product = Products::find($cartItem['product_id']);

                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                $product_variation = $cartItem['variation'];
                $product_stock = $product->product_stock;
                if ($cartItem['quantity'] > $product_stock->qty) {
                    flash(translate('The requested quantity is not available for ') . $product->name)->warning();
                    $order->delete();
                    return redirect()->route('cart')->send();
                } 
                else 
                {
                    $product_stock->qty -= $cartItem['quantity'];
                    $product_stock->save();
                }

                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->shipping_cost = $cartItem['shipping_cost'];

                $shipping += $order_detail->shipping_cost;
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->carrier_id = $cartItem['carrier_id'];
                $order_detail->save();

                $product->num_of_sale += $cartItem['quantity'];
                $product->save();

                $order->seller_id = $product->user_id;
                $order->shipping_type = $cartItem['shipping_type'];
                // $order->carrier_id = $cartItem['carrier_id'];


                if ($product->added_by == 'seller' && $product->user->seller != null) {
                    $seller = $product->user->seller;
                    $seller->num_of_sale += $cartItem['quantity'];
                    $seller->save();
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;


            $combined_order->grand_total += $order->grand_total;

            $order->save();
        }

        $combined_order->save();

        // foreach($combined_order->orders as $order){
           
        // }

        $request->session()->put('combined_order_id', $combined_order->id);
    }

    public function store_enterprise(Request $request)
    {
        $carts = Cart::where([['user_id', Auth::user()->id],['is_checked',1]])
            ->get()->append(['shpping_date']);

        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        $address = Address::where('id', $carts[0]['address_id'])->first();

        $shippingAddress = [];
        if ($address != null) {
            $shippingAddress['name']        = Auth::user()->name;
            $shippingAddress['email']       = Auth::user()->email;
            $shippingAddress['address']     = $address->address;
            $shippingAddress['country']     = $address->country->country_name;
            $shippingAddress['city']        = $address->city->city_name;
            $shippingAddress['district']    = $address->district->district_name;
            $shippingAddress['postal_code'] = $address->postal_code;
            $shippingAddress['phone']       = $address->phone;
        }

        // dd(json_encode($shippingAddress));
        $combined_order = new CombineOrder();
        $combined_order->customer_id = Auth::user()->id;
        $combined_order->shipping_address = json_encode($shippingAddress);
        $combined_order->save();

        $seller_products = array();
        foreach ($carts as $cartItem) {
            $product_ids = array();
            $product = Products::find($cartItem['product_id']);
            if (isset($seller_products[$product->user_id])) {
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem);
            $seller_products[$product->user_id] = $product_ids;
        }
       
       
        foreach ($seller_products as $seller_product) {
            $order = new Order;
            $order->combined_order_id = $combined_order->id;
            $order->customer_id = Auth::user()->id;
            $order->shipping_address = $combined_order->shipping_address;
            $order->payment_type = $request->payment_option;
            $order->payment_status = "unpaid";
            if($request->payment_option != "cash_on_delivery")
            {
                $order->payment_status = "waiting for checking";
            }
            $order->delivery_viewed = 0;
            $order->viewed = 0;
            $order->code = date('Ymd-His') . rand(10, 99);
            $order->order_date = Carbon::now();
            $order->save();

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $coupon_discount = 0;

            
            //Order Details Storing
            foreach ($seller_product as $cartItem) {
                $shipping_date = $cartItem['shipping_date'];
                $hour= Carbon::now()->addHour(7)->format('H:i');
                
                // dd(Carbon::parse($reservationStartingDate));
                $product = Products::find($cartItem['product_id']);

                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'] *  count($shipping_date);
                $product_variation = $cartItem['variation'];
                $product_stock = $product->product_stock;
                // if ($cartItem['quantity'] > $product_stock->qty) {
                //     flash(translate('The requested quantity is not available for ') . $product->name)->warning();
                //     $order->delete();
                //     return redirect()->route('cart')->send();
                // } 
                // else 
                //  {
                //     $product_stock->qty -= $cartItem['quantity'];
                //     $product_stock->save();
                // }
                foreach ($shipping_date as $each_shipping_date)
                {
                    $order_detail = new OrderDetail();
                    $order_detail->order_id = $order->id;
                    $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    $order_detail->variation = $product_variation;
                    
                    $order_detail->shipping_type = $cartItem['shipping_type'];
                    $order_detail->shipping_cost = $cartItem['shipping_cost']/ count($shipping_date);
                    

                    $shipping += $order_detail->shipping_cost;
                    //End of storing shipping cost

                    $order_detail->quantity = $cartItem['quantity'];
                
                    $order_detail->price = (cart_product_price($cartItem, $product, false, false) * $cartItem['quantity']);
                    $reservationStartingDate = $each_shipping_date ." ".$hour;
                    $order_detail->shipping_date = Carbon::parse($reservationStartingDate);
                    $order_detail->save();
                }
                

                $product->num_of_sale += $cartItem['quantity'] * count($shipping_date);
                $product->save();

                $order->seller_id = $product->user_id;
                $order->shipping_type = $cartItem['shipping_type'];
                $order->carrier_id = $cartItem['carrier_id'];


                if ($product->added_by == 'seller' && $product->user->seller != null) {
                    $seller = $product->user->seller;
                    $seller->num_of_sale += $cartItem['quantity'];
                    $seller->save();
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;


            $combined_order->grand_total += $order->grand_total;

            $order->save();
        }

        $combined_order->save();

        // foreach($combined_order->orders as $order){
           
        // }

        $request->session()->put('combined_order_id', $combined_order->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
