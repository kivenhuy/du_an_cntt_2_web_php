<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function addToCart(Request $request)
    {
        $product = Products::find($request->id);
        $carts = array();
        $data = array();
        if(auth()->user() != null) {
            $user_id = Auth::user()->id;
            $data['user_id'] = $user_id;
            $carts = Cart::where('user_id', $user_id)->get();
        } 
        else 
        {
            if($request->session()->get('temp_user_id')) {
                $temp_user_id = $request->session()->get('temp_user_id');
            } else {
                $temp_user_id = bin2hex(random_bytes(10));
                $request->session()->put('temp_user_id', $temp_user_id);
            }
            $data['temp_user_id'] = $temp_user_id;
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }
        $data['product_id'] = $product->id;
        $data['owner_id'] = $product->user_id;

        $str = '';
        $tax = 0;
        $data['variation'] = $str;

        $product_stock = $product->product_stock;
        $price = $product_stock->price;
        $quantity = $product_stock->qty;
        if($quantity < $request['quantity']) {
            return array(
                'status' => 0,
                'cart_count' => count($carts),
                'modal_view' => view('user_layout.partials.outOfStockCart')->render(),
                'nav_cart_view' => view('user_layout.partials.cart')->render(),
            );
        }
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['shipping_cost'] = 0;
        if ($request['quantity'] == null){
            $data['quantity'] = 1;
        }
        // dd($data);
        if($carts && count($carts) > 0)
        {
            $foundInCart = false;
            foreach ($carts as $key => $cartItem)
            {
                $cart_product = Products::where([['id', $cartItem['product_id']]])->first();
                if($cartItem['product_id'] == $request->id) {
                    $product_stock = $cart_product->product_stock;
                    $quantity = $product_stock->qty;
                    if($quantity < $cartItem['quantity'] + $request['quantity']){
                        return array(
                            'status' => 0,
                            'cart_count' => count($carts),
                            'modal_view' => view('user_layout.partials.outOfStockCart')->render(),
                            'nav_cart_view' => view('user_layout.partials.cart')->render(),
                        );
                    }
                    $foundInCart = true;
                    $cartItem['quantity'] += $request['quantity'];
                    $cartItem['price'] = $price;
                    $cartItem->save();
                }
            }
            if (!$foundInCart) {
                Cart::create($data);
            }
        }
        else{
            Cart::create($data);
        }

        if(auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }
        
        return array(
            'status' => 1,
            'cart_count' => count($carts),
            'modal_view' => view('user_layout.partials.addedToCart', compact('product', 'data'))->render(),
            'nav_cart_view' => view('user_layout.partials.cart')->render(),
        );
        
        
    }
}
