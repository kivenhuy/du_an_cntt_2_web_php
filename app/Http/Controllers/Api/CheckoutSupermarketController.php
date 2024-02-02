<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UploadsController;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\City;
use App\Models\CombineOrder;
use App\Models\Country;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\RequestForProduct;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class CheckoutSupermarketController extends Controller
{
    // update_shipping_fee

    public function update_select_item(Request $request)
    {
        $data_address = (int)$request->data['data_address'];
        $total = 0;
        $disabled = 0;
       
        if((int)$request->data['type'] === 1)
        {
            $carts = Cart::where('user_id', (int)$request->data['ecom_id'])->get();
            if(count($carts)>0)
            {
               
                foreach($carts as $data_cart)
                {
                    $product = Products::find($data_cart->product_id);
                    if((int)$request->data['active'] == 1)
                    {
                        $total = $total + cart_product_price($data_cart, $product, false) * $data_cart->quantity ;
                    }
                    $data_cart->update(['is_checked'=>(int)$request->data['active'],'address_id'=>$data_address]);
                } 
            }
        }
        else
        {
            $cart_data = Cart::find($request->data['cart_id']);
           
            $cart_data->update(['is_checked'=>$request->data['active'],'address_id'=>$data_address]);
            $all_cart = Cart::where([['is_checked',1],['user_id', (int)$request->data['ecom_id']]])->get();
            if(count($all_cart)>0)
            {
                foreach($all_cart as $data_cart)
                {
                    $product = Products::find($data_cart->product_id);
                    $total = $total + cart_product_price($data_cart, $product, false) * $data_cart->quantity ;
                } 
            }
        }
        if($total != 0)
        {
            $disabled = 1;
        }
        return response()->json([
            'result' => true,
            'message' => 'Update Cart Successfully',
            'data' => [
                'disabled'=>$disabled,
                'total'=>single_price($total)
            ]
        ]);
    }

    public function get_cart($id)
    {
        $total = 0;
        if($id == null) {
            return response()->json([
                'result' => false,
                'message' => 'User Not Found',
            ]);
        } 
        $carts = Cart::where('user_id', $id)->get()->append(['product_name','total_price','img_product']);
        if(count($carts)>0)
        {
            foreach($carts as $data_cart)
            {
                $product = Products::find($data_cart->product_id);
                $total = $total + cart_product_price($data_cart, $product, false) * $data_cart->quantity ;                
            } 
        }
        if(count($carts)>0)
        {
            $address = Address::where('user_id', $id)->get();
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
        return response()->json([
            'result' => true,
            'message' => 'Get Data Successfully',
            'data' => [
                'carts'=>$carts ,
                'address'=>$address,
                'total'=>single_price($total)
            ]
        ]);
    }

    public function update_shipping_fee(Request $request)
    {
        if ($request->data['address_id'] == null) {
            return response()->json([
                'result' => false,
                'message' => 'Please Select Address',
            ]);
        }

        $carts = Cart::where([['user_id', $request->data['ecom_id']],['is_checked',1]])->get();
        if($carts->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => 'Cart Empty',
            ]);
        }

        foreach ($carts as $cartItem) {
            $cartItem->address_id = $request->data['address_id'];
            $cartItem->save();
        }
        return response()->json([
            'result' => true,
            'message' => 'Update Addreess Successfully',
        ]);
    }

    public function final_checkout($id)
    {
        $seller_products = array();
        $seller_product_variation = array();
        $seller_products_normal = array();
        $seller_products_short = array();
        $carts_normal = array();
        $carts_short_shelf_life = array();
        $carts_normal = Cart::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','0');
        })->where([['user_id', $id],['is_checked',1]])->get()->append(['shipping_date','product_name','seller_name','total_price','img_product']);
        $carts_short_shelf_life = Cart::whereHas('product', function ($query) {
            $query->where('short_shelf_life','=','1');
        })->where([['user_id', $id],['is_checked',1]])->get()->append(['shipping_date','product_name','seller_name','total_price','img_product']);
        
        $discount = 0;
        $total_normal_product = 0;
        $total_short_product = 0;
        foreach ($carts_normal as $key => $cartItem){
            $product = Products::find($cartItem['product_id']);
            $data_rfp = RequestForProduct::find($cartItem->is_rfp);
            $shipping_time = 1;
            if(isset($data_rfp))
            {
                $shipping_time =count(json_decode($data_rfp->shipping_date));
            }
            $total_normal_product = $total_normal_product + cart_product_price($cartItem, $product, false) * $cartItem['quantity'] ;
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
            $data_rfp = RequestForProduct::find($carts_short_shelf_lifeItem->is_rfp);
            $shipping_time = 1;
            if(isset($data_rfp))
            {
                $shipping_time =count(json_decode($data_rfp->shipping_date));
            }
            $total_short_product = $total_short_product + cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity'] ;
            if(isset($seller_products[$product->user_id])){
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $carts_short_shelf_lifeItem['product_id']);
            $seller_products_short[$product->user_id] = $product_ids;
        }
        $carrier_list = Carrier::all()->append(['max_quantity','name_billing','shipping_price','shipping_price_normal']);
        // foreach($carrier_list as $each_carrier_list)
        // {

        // }
        return response()->json([
            'result' => true,
            'message' => 'Create Request For Product',
            'data' => [
                'discount'=>$discount,
                'carts_normal'=>$carts_normal,
                'carts_short_shelf_life'=>$carts_short_shelf_life,
                'seller_products_normal'=>$seller_products_normal,
                'seller_products_short'=>$seller_products_short,
                'carrier_list'=>$carrier_list,
                'total_short_product'=>single_price($total_short_product),
                'total_normal_product'=>single_price($total_normal_product),
                'final_price'=>single_price($total_normal_product + $total_short_product),
                'final_price_normal'=>($total_normal_product + $total_short_product),
            ]
        ]);
    }

    public function update_total_shipping_fee(Request $request)
    {
       
        $user = User::find($request->data['ecom_id']);
        $shipping_time = 1;
        
        if($request->data['type_cart'] === "normal_product")
        {
            if($request->data['shipping_type'] === "weight_based")
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
                ['owner_id',(int)$request->data['data_id_seller']],
                ['is_checked',1],
                ['is_rfp','!=',0],
            ])->get();
           
            foreach ($cart_data as $each_cart_data)
            { 
                $data_rfp = RequestForProduct::find($each_cart_data->is_rfp);
                if(isset($data_rfp))
                {
                    $shipping_time = count(json_decode(RequestForProduct::find($each_cart_data->is_rfp)->shipping_date));
                }
                $each_cart_data->update(
                    ['shipping_type' => $shipping_type,
                    'shipping_cost' => (int)$request->data['total_shipping'] * $shipping_time,
                    'carrier_id'=>(int)$request->data['data_id']]
                );
                
            }
        }
        else
        {
            $cart_data = Cart::whereHas('product', function ($query) {
                $query->where('short_shelf_life','=','1');
            })->where([
                ['user_id',$user->id],
                ['owner_id',(int)$request->data['data_id_seller']],
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
                    'shipping_cost' => $request->data['total_shipping'] * $shipping_time,
                    'carrier_id'=>(int)$request->data['data_id']]
                );
            }
        }
        $cart_shipping = Cart::where([
            ['user_id',$user->id],
            ['is_checked',1],
            ['is_rfp','!=',0],
        ])->sum('shipping_cost');
        $total_price = $cart_shipping + $request->data['final_price'];
        
        
        return response()->json([
            'result' => true,
            'message' => 'Update Shipping Price Successfully',
            'data' => [
                'total_price' =>single_price($total_price),
                'shipping_price'=>  single_price($cart_shipping),
            ]   
        ]);
        
    }

    public function checkout(Request $request)
    {  
        $photo_ids = [];
        
        if (!empty($request->data['photo_url'])) {
                                    
            $id = (new UploadsController)->upload_photo_supermarket($request->data['photo_url'],$request->data['ecom_id']);
            if (!empty($id)) {
                array_push($photo_ids, $id);
            }
        }
        if(count($photo_ids)>1)
        {
            $photo_img = implode(',', $photo_ids);
        }
        elseif(count($photo_ids) == 1)
        {
            $photo_img = $photo_ids[0];
        }else
        {
            $photo_img = null;
        }
        if ($request->data['payment_option'] != null) {

            $data_combine_id  =  $this->store_enterprise($request);


            // $request->session()->put('payment_type', 'cart_payment');
            
            // $data['combined_order_id'] = $request->session()->get('combined_order_id');
            // $request->session()->put('payment_data', $data);

            if ($data_combine_id  != null) 
            {                
                $combined_order = CombineOrder::findOrFail($data_combine_id);
                $manual_payment_data = array(
                    'name'   => $request->data['payment_option'],
                    'amount' => $combined_order->grand_total,
                    'trx_id' => $request->data['trx_id'],
                    'photo'  => $photo_img
                );
                foreach ($combined_order->orders as $order) {
                    $order->manual_payment = 1;
                    $order->manual_payment_data = json_encode($manual_payment_data);
                    $order->save();
                }
                $arr_order_details = [];
                foreach($combined_order->orders as $each_order)
                {
                    $arr_order_details[(int)$each_order->id]=$each_order->orderDetails;
                }
                Cart::where('user_id', $combined_order->customer_id)->delete();
                return response()->json([
                    'result' => true,
                    'message' => 'Checkout Successfully',
                    'data' => [
                        'first_order' =>$combined_order->orders->first(),
                        'combined_order_price' =>single_price($combined_order->grand_total),
                        'all_order' =>$combined_order->orders,
                        'arr_order_details' =>$arr_order_details,
                    ]   
                ]);
            }
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Checkout Failed',
            ]);
        }
    }

    // public function order_confirmed()
    // {
    //     $combined_order = CombineOrder::findOrFail(Session::get('combined_order_id'));

        

    //     return view('user_layout.checkout.order_confirmed', compact('combined_order'));
    // }

    public function store_enterprise(Request $request)
    {
        $carts = Cart::where([['user_id', $request->data['ecom_id']],['is_checked',1]])
            ->get()->append(['shpping_date']);

        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        $address = Address::where('id', $carts[0]['address_id'])->first();

        $shippingAddress = [];
        if ($address != null) {
            $shippingAddress['name']        = User::find($request->data['ecom_id'])->name;
            $shippingAddress['email']       = User::find($request->data['ecom_id'])->email;
            $shippingAddress['address']     = $address->address;
            $shippingAddress['country']     = $address->country->country_name;
            $shippingAddress['city']        = $address->city->city_name;
            $shippingAddress['district']    = $address->district->district_name;
            $shippingAddress['postal_code'] = $address->postal_code;
            $shippingAddress['phone']       = $address->phone;
        }

        // dd(json_encode($shippingAddress));
        $combined_order = new CombineOrder();
        $combined_order->customer_id = $request->data['ecom_id'];
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
            $order = new Order();
            $order->combined_order_id = $combined_order->id;
            $order->customer_id = $request->data['ecom_id'];
            $order->shipping_address = $combined_order->shipping_address;
            $order->payment_type = $request->data['payment_option'];
            $order->payment_status = "unpaid";
            if($request->data['payment_option'] != "cash_on_delivery")
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

                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                $product_variation = $cartItem['variation'];
                $product_stock = $product->product_stock;
                foreach ($shipping_date as $each_shipping_date)
                {
                    $order_detail = new OrderDetail();
                    $order_detail->order_id = $order->id;
                    $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    $order_detail->variation = $product_variation;
                    $order_detail->shipping_type = $cartItem['shipping_type'];
                    $order_detail->shipping_cost = $cartItem['shipping_cost'] / count($shipping_date);
                    $shipping += $order_detail->shipping_cost;
                    //End of storing shipping cost

                    $order_detail->quantity = $cartItem['quantity'];
                
                    $order_detail->price = (cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'])/ count($shipping_date);
                    $reservationStartingDate = $each_shipping_date ." ".$hour;
                    $order_detail->carrier_id = $cartItem['carrier_id'];
                    $order_detail->shipping_date = Carbon::parse($reservationStartingDate);
                    $order_detail->save();
                }
                

                $product->num_of_sale += $cartItem['quantity'] * count($shipping_date);
                $product->save();

                $order->seller_id = $product->user_id;
                $order->shipping_type = $cartItem['shipping_type'];
                


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
        return $combined_order->id;
    }

}
