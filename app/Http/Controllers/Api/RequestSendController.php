<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use App\Models\RequestForProduct;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Notification;
use Yajra\DataTables\DataTables;

class RequestSendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $all_request = RequestForProduct::orderByDesc('created_at')->where("buyer_id",(int)$request->buyer_id)->get()->append(['seller_name', 'unit_price']);
        return response()->json([
            'result' => true,
            'data'=>$all_request
        ]);
    }



    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seller = User::where('user_type','seller')->get();
        $request_for_product = new RequestForProduct();
        foreach($request->data as $data_request)
        {
            if($data_request['product_slug'] != "")
            {
                $data_product = Products::where('slug',$data_request['product_slug'])->first();
                if($data_product)
                {
                    $data_request['product_id'] =$data_product->id;
                }
                else
                {
                    $data_request['status'] =99;
                }
            }
            else
            {
                $data_request['status'] =97;
            }
            if($data_request['shop_slug'] != "")
            {
                $data_shop = Shop::where('slug',$data_request['shop_slug'])->first();
                if($data_shop)
                {
                    $data_request['shop_id'] =$data_shop->id;
                }
                else
                {
                    $data_request['status'] =98;
                }
            }
            $success_requets = $request_for_product->create($data_request);
            if($success_requets->shop_id != 0)
            {
                $seller = Shop::find($success_requets->shop_id)->user;
            }
            Notification::send($seller, new WelcomeNotification($success_requets));
            
        }
        return response()->json([
            'result' => true,
            'message' => 'Create Request For Product',
            'is_success' =>0
        ]);
        // if($request_for_product)
        // {
        //     flash(translate('Request for Product has been inserted successfully'))->success();
        //     return back();
        // }
        // else
        // {
        //     flash(translate('Request for Product has been inserted failed'))->danger();
        //     return back();
        // }
    }

   

    public function show($id)
    {
        $data_request = RequestForProduct::find($id)->append(['seller_name', 'unit_price']);
        if($data_request)
        {
            $product = Products::where('id',$data_request->product_id)->first()->append('img_url');
            $buyer = User::find($data_request->buyer_id);
            $seller = Shop::where('id',$data_request->shop_id)->first();
            return response()->json([
                'result' => false,
                'message'=>'Get data Successfully',
                'data'=>[
                    'product'=>(object)$product,
                    'buyer'=>$buyer,
                    'seller'=>(object)$seller,
                    'data_request'=>$data_request,
                ]
            ]);
        }
        else
        {
            return response()->json([
                'result' => false,
                'message'=>'Data not found',
                'data'=>[]
            ]);
        }
    }


    public function approve_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['status' => 4]);
            $update_cart = $this->addToCart_RFP_request($request->id_rfp);
            if($update_cart)
            {
                return response()->json([
                    'result' => true,
                    'message'=>'Product Added To Cart Successfully',
                    'data'=>true
                ]);
            }
        }
    }

    public function reject_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['status' => 2]);
        }
        return response()->json([
            'result' => true,
            'message'=>'Reject Price Successfully',
            'data'=>true
        ]);
        
    }

    public function addToCart_RFP_request($id)
    {
        $rfp_record = RequestForProduct::find($id);
        $product = Products::find($rfp_record->product_id);
        $carts = array();
        $data = array();

        if($rfp_record->buyer_id != null) {
            $data['user_id'] = $rfp_record->buyer_id;
            $carts = Cart::where('user_id', $rfp_record->buyer_id)->get();
        }else{
            return false;
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
        $data['is_rfp'] = $id;
        // if ($request['quantity'] == null){
        //     $data['quantity'] = 1;
        // }

        if($carts && count($carts) > 0)
        {
            $foundInCart = false;
            foreach ($carts as $key => $cartItem)
            {
                $cart_product = Products::where([['id', $cartItem['product_id']]])->first();
                if($cartItem['product_id'] == $product->id &&  $cartItem['is_rfp'] == 1 && $cartItem['price'] == $price) {
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

        if($rfp_record->buyer_id != null) {
            $carts = Cart::where('user_id',$rfp_record->buyer_id)->get();
        }
        else
        {
            return false;
        }
        return true;
        // return array(
        //     'status' => 1,
        //     'cart_count' => count($carts),
        //     'modal_view' => view('user_layout.partials.addedToCart', compact('product', 'data'))->render(),
        //     'nav_cart_view' => view('user_layout.partials.cart')->render(),
        // );
        
    }

    public function destroy($id)
    {
        $data_request = RequestForProduct::find($id)->delete();
        return response()->json([
            'result' => true,
            'data'=>1
        ]);
    }
}
