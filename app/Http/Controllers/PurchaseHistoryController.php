<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Uploads;
use Illuminate\Pagination\Paginator;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->where('customer_id', Auth::user()->id)
            ->where('admin_approve_status', 'approved')
            ->select('orders.id')
            ->distinct();

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(10);
        // dd($orders);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }
        return view('user_layout.purchase_history.index',compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    // public function data_ajax(Request $request)
    // {
    //     $data_request = Order::with('orderDetails')->where('customer_id', Auth::user()->id)->orderBy('code', 'desc')->get();
    //     $out =  DataTables::of($data_request)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         $output .= ' <a href="'.url(route('purchase_history.get_detail',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Order Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
    //         $data->data[$i]->action = (string)$output;
    //         $data->data[$i]->grand_total = single_price($data->data[$i]->grand_total);
    //         $data->data[$i]->delivery_status = (ucfirst($data->data[$i]->delivery_status));
    //         $data->data[$i]->payment_status = (ucfirst($data->data[$i]->payment_status));
    //     }
    //     $out->setData($data);
       
    //     return $out;
    // }

    public function get_detail($id)
    {
        $order = Order::find(decrypt($id));
       
        $order->delivery_viewed = 1;
        $order->save();
        
        $array_images = [];
        
        if(isset($order->manual_payment_data))
        {
           
            $data_manual = json_decode($order->manual_payment_data);
            // dd($order->manual_payment_data);
            $data_uploads = $data_manual->photo;
            
			if(isset($data_uploads))
            {
                if (str_contains($data_uploads, ',')) {
                    $data_uploads = explode(",", $data_uploads);
                    foreach($data_uploads as $data_photo)
                    {
                        $data_images = Uploads::findOrFail($data_photo);
                        array_push($array_images,$data_images->file_name);
                    }
                }
                else
                {
                    $data_uploads = $data_manual->photo;
                    $data_images = Uploads::findOrFail($data_uploads);
                    array_push($array_images,$data_images->file_name);
                }            
                
            }
            $order->img_url = $array_images;
            $order->name_payment = $data_manual->name;
            $order->amount_payment = $data_manual->amount;
            $order->trx_id = $data_manual->trx_id;
        }          
        // dd($order);
	    return view('user_layout.purchase_history.order_details', compact('order'));
    }
}
