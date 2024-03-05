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
use Http;
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
                try
                {
                    $upsteamUrl = env('SHIPPING_URL');
                    $signupApiUrl = $upsteamUrl . '/shipper/notification';
                    $response = Http::post($signupApiUrl,[
                        'order_detail_id'=>$order_detail->id,
                        'customer_name'=>Auth::user()->name,
                        'carrier_id'=>$order_detail->carrier_id,
                        'customer_type'=>Auth::user()->user_type,
                    ]);
                    // dd(json_decode($response));
                
                }
                catch(\Exception $exception) {
                    
                }
                $product->num_of_sale += $cartItem['quantity'];
                $product->current_stock -= $cartItem['quantity'];
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
            // if($request->payment_option == "vnpay")
            // {
            //     $vnpay_check = $this->VNPay($order);
            // }
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
                
                    $order_detail->price = (cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'])/count($shipping_date);
                    $reservationStartingDate = $each_shipping_date ." ".$hour;
                    $order_detail->shipping_date = Carbon::parse($reservationStartingDate);
                    $order_detail->carrier_id = $cartItem['carrier_id'];
                    $order_detail->save();
                    try
                    {
                        $upsteamUrl = env('SHIPPING_URL');
                        $signupApiUrl = $upsteamUrl . '/shipper/notification';
                        $response = Http::post($signupApiUrl,[
                            'order_detail_id'=>$order_detail->id,
                            'customer_name'=>Auth::user()->name,
                            'carrier_id'=>$order_detail->carrier_id,
                            'customer_type'=>Auth::user()->user_type,
                        ]);
                        // dd(json_decode($response));
                    
                    }
                    catch(\Exception $exception) {
                        
                    }
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

    public function VNPay($data)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "";//Mã website tại VNPAY 
        $vnp_HashSecret = ""; //Chuỗi bí mật

        $vnp_TxnRef = $data->code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Checkout Order";
        $vnp_OrderType = "Payment";
        $vnp_Amount = $data->grand_total;
        $vnp_Locale = 'VN';
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
        // $vnp_Bill_City=$_POST['txt_bill_city'];
        // $vnp_Bill_Country=$_POST['txt_bill_country'];
        // $vnp_Bill_State=$_POST['txt_bill_state'];
        // // Invoice
        // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
        // $vnp_Inv_Email=$_POST['txt_inv_email'];
        // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
        // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
        // $vnp_Inv_Company=$_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type=$_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
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
