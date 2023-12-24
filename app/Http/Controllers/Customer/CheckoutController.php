<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use Auth;
use Illuminate\Http\Request;

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
        $carts = Cart::where([['user_id', Auth::user()->id],['is_checked',1]])->get();
        $seller_products = array();
        $seller_product_variation = array();
        $discount = 0;
        foreach ($carts as $key => $cartItem){
            $product = Products::find($cartItem['product_id']);
            $product_ids = array();
            if(isset($seller_products[$product->user_id])){
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem['product_id']);
            $seller_products[$product->user_id] = $product_ids;
        }
        $carrier_list = array();
        return view('user_layout.checkout.payment_select', compact('discount','carts','seller_products','carrier_list'));
    }

}