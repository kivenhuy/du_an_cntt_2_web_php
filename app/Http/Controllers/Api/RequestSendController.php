<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\RequestForProduct;
use App\Models\Shop;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\DataTables;

class RequestSendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $all_request = RequestForProduct::where("buyer_id",(int)$request->buyer_id)->get()->append(['seller_name', 'unit_price']);
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
        $request_for_product = new RequestForProduct();
        foreach($request->data as $data_request)
        {
            $request_for_product->create($data_request);
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
