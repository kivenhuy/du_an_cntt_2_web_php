<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Uploads;
use App\Models\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = Order::orderBy('id', 'desc')
            ->where('admin_approve_status', 'approved')
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

        $orders = $orders->paginate(15);
        return view('admin.purchase_history.index',compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    public function data_ajax(Request $request)
    {
        $data_request = Order::with('orderDetails')->orderBy('code', 'desc')->get();
        $out =  DataTables::of($data_request)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $output .= ' <a href="'.url(route('admin.purchase_history.get_detail',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Order Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            $data->data[$i]->action = (string)$output;
            $data->data[$i]->customer_name = User::find($data->data[$i]->customer_id)->name;
            $data->data[$i]->seller_name = User::find($data->data[$i]->seller_id)->name;
            $data->data[$i]->grand_total = single_price($data->data[$i]->grand_total);
            $data->data[$i]->payment_type = (ucfirst(str_replace('_', ' ', $data->data[$i]->payment_type)));
            $data->data[$i]->delivery_status = (ucfirst($data->data[$i]->delivery_status));
            $data->data[$i]->payment_status = (ucfirst($data->data[$i]->payment_status));
            $data->data[$i]->total_product = count(Order::find($data->data[$i]->id)->orderDetails);
        }
        $out->setData($data);
       
        return $out;
    }

    public function get_detail($id)
    {
        $order = Order::find($id);
    
        // dd($order->amount_price);
        $order->delivery_viewed = 1;
        $order->save();
        
        $array_images = [];
        
        if(isset($order->manual_payment_data))
        {
           
            $data_manual = json_decode($order->manual_payment_data);
            $data_uploads = $data_manual->photo;
			if(isset($data_uploads))
            {
                if (str_contains($data_uploads, ',')) {
                    $data_uploads = explode(",", $data_uploads);
                    foreach($data_uploads as $data_photo)
                    {
                        // $data_images = Uploads::findOrFail($data_photo);
                        array_push($array_images,uploaded_asset($data_photo));
                    }
                }
                else
                {
                    $data_uploads = $data_manual->photo;
                    // $data_images = Uploads::findOrFail($data_uploads);
                    array_push($array_images,uploaded_asset($data_uploads));
                }            
                
            }
            $order->img_url = $array_images;
            // dd($order->img_url);
            $order->name_payment = $data_manual->name;
            $order->amount_payment = $data_manual->amount;
            $order->trx_id = $data_manual->trx_id;
        }          
	    return view('admin.purchase_history.order_details', compact('order'));
    }

    public function verify_payment(Request $request)  {
        $order_data = Order::find($request->order_id);
       
        $order_data->payment_status = 'paid';
        $order_data->save();
            // $order_data->update(['payment_status','paid']);
        
        
    }
}
