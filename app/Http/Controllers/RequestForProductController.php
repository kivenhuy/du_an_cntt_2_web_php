<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\RequestForProduct;
use App\Models\Shop;
use App\Models\User;
use Auth;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\DataTables;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\DB;

class RequestForProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = null;
        $sort_search = null;
        $request_data = RequestForProduct::orderBy('id', 'desc')
            ->where('buyer_id', Auth::user()->id)
            ->distinct();
        if ($request->status != null) {
            $request_data = $request_data->where('status',(int) $request->status);
            $status = $request->status;
        }
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $request_data = $request_data->where('code', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $request_data = $request_data->paginate(10);
        
        
       return view('user_layout.request_product.index',compact('request_data', 'status', 'sort_search'));
    }

    public function seller_supermarket_index(Request $request)
    {
        $status = null;
        $sort_search = null;
        $request_data = RequestForProduct::orderBy('id', 'desc')
            ->orderBy('id', 'desc')
            ->where('shop_id', Auth::user()->shop->id)
            ->where('is_supermarket_request',1);
        if ($request->status != null) {
            $request_data = $request_data->where('status',(int) $request->status);
            $status = $request->status;
        }
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $request_data = $request_data->where('code', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $request_data = $request_data->paginate(10);
        // dd($request_data);
        return view('seller.request_product.supermarket_index',compact('request_data', 'status', 'sort_search'));
    }

    public function seller_index(Request $request)
    {
        $status = null;
        $sort_search = null;
        $request_data = RequestForProduct::orderBy('id', 'desc')
            ->orderBy('id', 'desc')
            ->where('shop_id', Auth::user()->shop->id)
            ->where('is_supermarket_request','!=',1);
        if ($request->status != null) {
            $request_data = $request_data->where('status',(int) $request->status);
            $status = $request->status;
        }
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $request_data = $request_data->where('code', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $request_data = $request_data->paginate(10);
       return view('seller.request_product.index',compact('request_data', 'status', 'sort_search'));
    }
    public function admin_index(Request $request)
    {
        $status = null;
        $sort_search = null;
        $request_data = RequestForProduct::orderBy('id', 'desc')
            ->orderBy('id', 'desc')
            ->where('is_supermarket_request','!=',1)
            ->distinct();
        if ($request->status != null) {
            $request_data = $request_data->where('status',(int) $request->status);
            $status = $request->status;
        }
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $request_data = $request_data->where('code', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $request_data = $request_data->paginate(10);
       return view('admin.request_product.index',compact('request_data', 'status', 'sort_search'));
    }
    
    public function admin_supermarket_index(Request $request)
    {
        $status = null;
        $sort_search = null;
        $request_data = RequestForProduct::orderBy('id', 'desc')
            ->orderBy('id', 'desc')
            ->where('is_supermarket_request','=',1)
            ->distinct();
        if ($request->status != null) {
            $request_data = $request_data->where('status',(int) $request->status);
            $status = $request->status;
        }
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $request_data = $request_data->where('code', 'like', '%' . $sort_search . '%');
        }
        $request_data = $request_data->paginate(10);
       return view('admin.request_product.supermarket_index',compact('request_data', 'status', 'sort_search'));
    }

    public function admin_approved(Request $request)
    {
        $seller = User::where('user_type','seller')->get();
        if(Auth::user()->user_type != 'admin')
        {
            return 0;
        }
        $request_product = RequestForProduct::findOrFail($request->id);
        $request_product->status = 1;
        if ($request_product->save()) {
            Notification::send($seller, new WelcomeNotification($request_product));
            return 1;
        }
    }

    public function seller_update_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $price =$request->price; // 1,000,000
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['price' => $price,'status' => 3]);
        }
    }

    public function seller_accept_request(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $price =$request->price; // 1,000,000
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            if($Rfq_data)
            {
                $Rfq_data->update(['product_id' => $request->product_id,'shop_id'=>Auth::user()->shop->id,'status' => 2]);
            }   
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
        $current_timestamp = mt_rand(1000000000, 9999999999);
        $code_rfq = $ldate.'-'.$current_timestamp;
        $start = Carbon::parse($request->from_date);
        $start_date = $start;
        $end =  Carbon::parse($request->to_date);
        $days = $end->diffInDays($start);
        $distance_between_date = intdiv($days,(int)$request->order_date);
        $arr_shipping_date = [];
        array_push($arr_shipping_date,$start->format('m/d/Y'));
        for($i = 0;$i <= $distance_between_date-1;$i++)
        {
            $start_date = $start_date->addDay((int)$request->order_date);
            array_push($arr_shipping_date,$start_date->format('m/d/Y'));
        }
        $data_request = [
            'product_id'=>$request->product_id,
            'code'=>$code_rfq,
            'product_name'=>Products::find($request->product_id)->name,
            'shop_id'=>$request->shop_id,
            'buyer_id'=>Auth::user()->id,
            'from_date'=>Carbon::parse($request->from_date),
            'to_date'=>$end,
            'shipping_date'=>json_encode($arr_shipping_date),
            'distance_between_shipping_date' =>(int)$request->order_date,
            'quantity'=>$request->quantity,
            'unit'=>$request->unit,
            'price'=>0,
            'status'=>0,
        ];
        $seller = Shop::find($request->shop_id)->user;
        $success_requets = $request_for_product->create($data_request);
        Notification::send($seller, new WelcomeNotification($success_requets));
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
            $product = Products::where('id',$data_request->product_id)->first();
            $buyer = User::find($data_request->buyer_id);
            $seller = Shop::where('id',$data_request->shop_id)->first();
            if(Auth::user()->user_type == 'enterprise')
            {
                return view('user_layout.request_product.show',['product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
            }
            elseif(Auth::user()->user_type == 'seller')
            {
                $is_accept = 0;
                $product_id = 0;
                if($data_request->product_id == 0)
                {
                    $data_product = Products::where([['name', 'like', '%' .$data_request->product_name. '%'],['user_id',Auth::user()->id]])->first();
                    // dd($data_product);
                    if(!empty($data_product))
                    
                    {
                        $is_accept = 1;  
                        $product_id = $data_product->id;
                    }
                }   
                return view('seller.request_product.show',['product_id'=>$product_id,'is_accept'=>$is_accept,'product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
            }
            else
            {
                return view('admin.request_product.show',['product'=>$product,'buyer'=>$buyer,'seller'=>$seller,'data_request'=>$data_request]);
            }
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


    // public function customer_dataajax(Request $request)
    // {
    //     $data_request = RequestForProduct::where([['buyer_id',Auth::user()->id],['product_id','!=',0]])->get();
    //     $out =  DataTables::of($data_request)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         $data->data[$i]->seller_name = Shop::find($data->data[$i]->shop_id)?->name;
    //         $data->data[$i]->price = single_price($data->data[$i]->price);
    //         $data->data[$i]->action = (string)$output;
    //         }
    //     $out->setData($data);
    //     return $out;
    // }

    // public function seller_dataajax(Request $request)
    // {
        
    //     $data_request = RequestForProduct::where([['shop_id',Auth::user()->shop->id],['is_supermarket_request','!=',1]])->get();
    //     $out =  DataTables::of($data_request)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) 
    //     {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         $data->data[$i]->product_name = Products::find($data->data[$i]->product_id)->name;
    //         $data->data[$i]->buyer_name = User::find($data->data[$i]->buyer_id)->name;
    //         $data->data[$i]->action = (string)$output;
    //     }
    //     $out->setData($data);
    //     return $out;
    // }

    // public function seller_supermarket_dataajax(Request $request)
    // {
        
    //     $data_request = RequestForProduct::where([['is_supermarket_request',1]])->get();
    //     $out =  DataTables::of($data_request)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) 
    //     {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         if($data->data[$i]->status != 0)
    //         {
    //             $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         }
            
    //         $data->data[$i]->buyer_name = User::find($data->data[$i]->buyer_id)->name;
    //         $data->data[$i]->action = (string)$output;
    //     }
    //     $out->setData($data);
    //     return $out;
    // }

    // public function admin_supermarket_dataajax(Request $request)
    // {
    //     $data_request = RequestForProduct::where([['is_supermarket_request',1]])->get();
    //     $out =  DataTables::of($data_request)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         $data->data[$i]->buyer_name = User::find($data->data[$i]->buyer_id)->name;
    //         $data->data[$i]->seller_name = Shop::find($data->data[$i]->shop_id)?->name;
    //         $data->data[$i]->price = single_price($data->data[$i]->price);
    //         $data->data[$i]->action = (string)$output;
    //         }
    //     $out->setData($data);
    //     return $out;
    // }

    // public function admin_dataajax(Request $request)
    // {
    //     $data_request = RequestForProduct::where([['product_id','!=',0],['is_supermarket_request',0]])->get();
    //     $out =  DataTables::of($data_request)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         $output .= ' <a href="'.url(route('request_for_product.get_details_data',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Show Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         $data->data[$i]->buyer_name = User::find($data->data[$i]->buyer_id)->name;
    //         $data->data[$i]->seller_name = Shop::find($data->data[$i]->shop_id)?->name;
    //         $data->data[$i]->price = single_price($data->data[$i]->price);
    //         $data->data[$i]->action = (string)$output;
    //         }
    //     $out->setData($data);
    //     return $out;
    // }

    public function approve_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['status' => 4]);
        }
    }

    public function reject_price(Request $request)
    {
        if(isset($request->id_rfp))
        {
            $Rfq_data = RequestForProduct::find($request->id_rfp);
            $Rfq_data->update(['status' => 2,'price'=>0,'offer_price'=>$request->price]);
        }
    }
}
