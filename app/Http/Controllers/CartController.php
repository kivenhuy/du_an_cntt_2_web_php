<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Products;
use App\Models\RequestForProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } 
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        if(count($carts)>0)
        {
            $address = Address::where('user_id', Auth::user()->id)->get();
            foreach($address as $data_address)
            {
                $city_name = City::find($data_address->city_id)->city_name;
                $country_name = Country::find($data_address->country_id)->country_name;
                $district_name = District::find($data_address->district_id)->district_name;
                $user_name = User::find($data_address->user_id)->name;
                $str = $user_name.', '.$data_address->phone.', '.$data_address->address.', '.$district_name.', '.$city_name.', '.$country_name;
                $data_address->full_adress = $str;
            }
        }
        else{
            $address = [];
        }
        return view('user_layout.partials.cart_view', compact('carts','address'));
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
        $data['is_rfp'] = 0;
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
                if($cartItem['product_id'] == $request->id  && $cartItem['is_rfp'] == 0) {
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

    public function removeFromCart(Request $request)
    {
        Cart::destroy($request->id);
        if(auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        return array(
            'cart_count' => count($carts),
            'cart_view' => view('user_layout.partials.cart_details', compact('carts'))->render(),
            'nav_cart_view' => view('user_layout.partials.cart')->render(),
        );
    }

    public function update_select_item(Request $request)
    {
        if((int)$request->data_address == 0)
        {
            $data_address = 0;
        }
        else
        {
            $data_address = (int)$request->data_address;
        }
        $total = 0;
        $disabled = 0;
        if($request->type == 1)
        {
            $carts = Cart::where('user_id', Auth::user()->id)->get();
            if(count($carts)>0)
            {
                foreach($carts as $data_cart)
                {
                    $product = Products::find($data_cart->product_id);
                    if($request->active == 1)
                    {
                        $total = $total + cart_product_price($data_cart, $product, false) * $data_cart->quantity;
                    }
                    $data_cart->update(['is_checked'=>$request->active,'address_id'=>$data_address]);
                } 
            }
        }
        else
        {
            $cart_data = Cart::find($request->cart_id);
            $cart_data->update(['is_checked'=>$request->active,'address_id'=>$data_address]);
            $all_cart = Cart::where('is_checked',1)->get();
            if(count($all_cart)>0)
            {
                foreach($all_cart as $data_cart)
                {
                        $product = Products::find($data_cart->product_id);
                        $total = $total + cart_product_price($data_cart, $product, false) * $data_cart->quantity;
                } 
            }
        }
        if($total != 0)
        {
            $disabled = 1;
        }
        return ['total'=>single_price($total),'disabled'=>$disabled];
    }

    public function updateQuantity(Request $request)
    {
        $cartItem = Cart::findOrFail($request->id);
        if($cartItem['id'] == $request->id){
            $product = Products::find($cartItem['product_id']);
            $product_stock = $product->product_stock->where('variant', $cartItem['variation'])->first();
            $quantity = $product_stock->qty;
            $price = $product_stock->price;
			
			//discount calculation
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

            if($quantity >= $request->quantity) {
                if($request->quantity >= $product->min_qty){
                    $cartItem['quantity'] = $request->quantity;
                }
            }
            $cartItem['price'] = $price;
            $cartItem->save();
        }

        if(auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        }
        if(count($carts)>0)
        {
            $address = Address::where('user_id', Auth::user()->id)->get();
            foreach($address as $data_address)
            {
                $city_name = City::find($data_address->city_id)->city_name;
                $country_name = Country::find($data_address->country_id)->country_name;
                $district_name = District::find($data_address->district_id)->district_name;
                $user_name = User::find($data_address->user_id)->name;
                $str = $user_name.', '.$data_address->phone.', '.$data_address->address.', '.$city_name.', '.$district_name.', '.$country_name;
                $data_address->full_adress = $str;
            }
        }
        else{
            $address = [];
        }
        return array(
            'cart_count' => count($carts),
            'cart_view' => view('user_layout.partials.cart_details', compact('carts','address'))->render(),
            'nav_cart_view' => view('user_layout.partials.cart')->render(),
        );
    }

    public function addToCart_RFP_request(Request $request)
    {
        $rfp_record = RequestForProduct::find($request->id_rfp);
        $product = Products::find($rfp_record->product_id);
        $carts = array();
        $data = array();

        if(auth()->user() != null) {
            $user_id = Auth::user()->id;
            $data['user_id'] = $user_id;
            $carts = Cart::where('user_id', $user_id)->get();
        } 

        $data['product_id'] = $product->id;
        $data['owner_id'] = $product->user_id;

        $str = '';
        $tax = 0;
       
        $price = $rfp_record->price;
        $product->unit_price = $rfp_record->price;
        $shipping_time = json_decode($rfp_record->shipping_date);
        $data['quantity'] = $rfp_record->quantity;
        $data['price'] = $price * count($shipping_time);
        //$data['shipping'] = 0;
        $data['shipping_cost'] = 0;
        $data['is_rfp'] = $request->id_rfp;
        // if ($request['quantity'] == null){
        //     $data['quantity'] = 1;
        // }

        if($carts && count($carts) > 0)
        {
            $foundInCart = false;
            foreach ($carts as $key => $cartItem)
            {
                $cart_product = Products::where([['id', $cartItem['product_id']]])->first();
                if($cartItem['product_id'] == $product->id &&  $cartItem['is_rfp'] != 0 &&  $cartItem['price'] == $price) {
                    $product_stock = $cart_product->product_stock;
                    $quantity = $product_stock->qty;
                    $foundInCart = true;
                    $cartItem['quantity'] += $rfp_record->quantity;
                    $cartItem['price'] = $price;
                    $cartItem->save();
                }
            }
            if (!$foundInCart) {
                Cart::create($data);
            }
        }
        else
        {
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
