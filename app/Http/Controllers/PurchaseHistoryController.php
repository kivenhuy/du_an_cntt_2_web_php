<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Uploads;
use Auth;
use DataTables;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        return view('user_layout.purchase_history.index');
    }

    public function data_ajax(Request $request)
    {
        $data_request = Order::with('orderDetails')->where('customer_id', Auth::user()->id)->orderBy('code', 'desc')->get();
        $out =  DataTables::of($data_request)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $output .= ' <a href="'.url(route('purchase_history.get_detail',['id'=>$data->data[$i]->id])).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Order Details" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-eye"></i></a>';
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
       
        return $out;
    }

    public function get_detail($id)
    {
        $order = Order::find($id);
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
	    return view('user_layout.purchase_history.order_details', compact('order'));
    }
}
