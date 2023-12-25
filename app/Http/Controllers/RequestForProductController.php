<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\RequestForProduct;
use App\Models\Shop;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\DataTables;

class RequestForProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('user_layout.request_product.index');
    }

    public function seller_index()
    {
       return view('seller.request_product.index');
    }
    public function admin_index()
    {
       return view('admin.request_product.index');
    }

    public function admin_approved(Request $request)
    {
        if(Auth::user()->user_type != 'admin')
        {
            return 0;
        }
        $request_product = RequestForProduct::findOrFail($request->id);
        $request_product->status = 1;
        if ($request_product->save()) {
            return 1;
        }
    }

    public function seller_update_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $price =$request->price; // 1,000,000
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['price' => $price,'status' => 2]);
        }
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
        $request_for_product = new RequestForProduct();
        $ldate = date('Ymd');
        $current_timestamp = Carbon::now()->timestamp; 
        $code_rfq = $ldate.'-'.$current_timestamp;
        $start = Carbon::parse($request->from_date);
        $start_date = $start;
        $end =  Carbon::parse($request->to_date);
        $days = $end->diffInDays($start);
        $distance_between_date = intdiv($days,(int)$request->order_date);
        $arr_shipping_date = [];
        array_push($arr_shipping_date,$start->format('m/d/Y'));
        for($i = 0;$i <= $distance_between_date;$i++)
        {
            $start_date = $start_date->addDay((int)$request->order_date);
            array_push($arr_shipping_date,$start_date->format('m/d/Y'));
        }
        $data_request = [
            'product_id'=>$request->product_id,
            'code'=>$code_rfq,
            'shop_id'=>$request->shop_id,
            'buyer_id'=>Auth::user()->id,
            'from_date'=>$start,
            'to_date'=>$end,
            'shipping_date'=>json_encode($arr_shipping_date),
            'distance_between_shipping_date' =>(int)$request->order_date,
            'quantity'=>$request->quantity,
            'unit'=>$request->unit,
            'price'=>0,
            'status'=>0,
        ];
        $request_for_product->create($data_request);
        if($request_for_product)
        {
            flash(translate('Request for Product has been inserted successfully'))->success();
            return back();
        }
        else
        {
            flash(translate('Request for Product has been inserted failed'))->danger();
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestForProduct $requestForProduct)
    {
        //
    }

    public function get_details_data($id)
    {
        $data_request = RequestForProduct::find($id);
        if($data_request)
        {
            $product = Products::find($data_request->product_id);
            $buyer = User::find($data_request->buyer_id);
            $seller = Shop::find($data_request->shop_id);
            if(Auth::user()->user_type == 'enterprise')
            {
                return view('user_layout.request_product.show',['product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
            }
            elseif(Auth::user()->user_type == 'seller')
            {
                return view('seller.request_product.show',['product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
            }
            else
            {
                return view('admin.request_product.show',['product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
            }
        }
        else
        {
            flash(translate('Some missing happend'))->danger();
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestForProduct $requestForProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestForProduct $requestForProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestForProduct $requestForProduct)
    {
        //
    }


    public function customer_dataajax(Request $request)
    {
        $data_request = RequestForProduct::where('buyer_id',Auth::user()->id)->get();
        $out =  DataTables::of($data_request)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            $data->data[$i]->product_name = Products::find($data->data[$i]->product_id)->name;
            $data->data[$i]->seller_name = Shop::find($data->data[$i]->shop_id)->name;
            $data->data[$i]->price = single_price($data->data[$i]->price);
            $data->data[$i]->action = (string)$output;
            }
        $out->setData($data);
        return $out;
    }

    public function seller_dataajax(Request $request)
    {
        $data_request = RequestForProduct::where('shop_id',Auth::user()->shop->id)->get();
        $out =  DataTables::of($data_request)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) 
        {
            // dd($data->data[$i]->id);
            $output = '';
            $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            $data->data[$i]->product_name = Products::find($data->data[$i]->product_id)->name;
            $data->data[$i]->buyer_name = User::find($data->data[$i]->buyer_id)->name;
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }

    public function admin_dataajax(Request $request)
    {
        $data_request = RequestForProduct::all();
        $out =  DataTables::of($data_request)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            $data->data[$i]->product_name = Products::find($data->data[$i]->product_id)->name;
            $data->data[$i]->buyer_name = User::find($data->data[$i]->buyer_id)->name;
            $data->data[$i]->seller_name = Shop::find($data->data[$i]->shop_id)->name;
            $data->data[$i]->price = single_price($data->data[$i]->price);
            $data->data[$i]->action = (string)$output;
            }
        $out->setData($data);
        return $out;
    }

    public function approve_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['status' => 3]);
        }
    }

    public function reject_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['status' => 1,'price'=>0,'offer_price'=>$request->price]);
        }
    }
}
