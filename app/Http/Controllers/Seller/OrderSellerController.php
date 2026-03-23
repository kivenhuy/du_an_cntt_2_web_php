<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Uploads;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class OrderSellerController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->where('seller_id', Auth::user()->id)
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

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }

        return view('seller.orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    public function show(Request $request, $id)
    {
        if (!empty($request->notification_id)) {
            DB::table('notifications')->where('id', $request->notification_id)->update(['read_at' => now()]);
        }
        
        $order = Order::findOrFail(decrypt($id));
        $order_shipping_address = json_decode($order->shipping_address);
        $order->viewed = 1;
        $order->save();
        $array_images = [];
        if(isset($order->manual_payment_data))
        {
            $data_manual = json_decode($order->manual_payment_data);
            if($data_manual->photo != null)
            {
                $data_uploads = $data_manual->photo;
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
            else
            {
                $array_images = [];
            }
            $order->img_url = $array_images;
            $order->name_payment = $data_manual->name;
            $order->amount_payment = $data_manual->amount;
            $order->trx_id = $data_manual->trx_id;
        }
        return view('seller.orders.show', compact('order'));
    }

   

}
