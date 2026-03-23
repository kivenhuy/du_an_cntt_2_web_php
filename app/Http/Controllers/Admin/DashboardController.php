<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\ShipperDetail;
use App\Models\Shop;
use App\Models\User;
use DB;
use Http;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data_revenue = [];
        $shipping_status = [];
        $quantity_product = [];
        $customer = User::where('user_type','customer')->count();
        $enterprise = User::where('user_type','enterprise')->count();
        $seller = Shop::count();
        $shipper = [];
        try
        {
            $upsteamUrl = env('SHIPPING_URL');
            $signupApiUrl = $upsteamUrl . '/get_all_shipper';
            $response = Http::get($signupApiUrl);
            $data_response = (json_decode($response)->data);
            $shipper = $data_response->shipper;
        }
        catch(\Exception $exception) {
            
        }
        $shipper_data = count($shipper);
        // $shipper = ShipperDetail::where('user_type','customer')->count();
        $product = Products::count();
        $total_revenue_by_card = Order::where('payment_type','bank_payment')->sum('grand_total');
        $data_revenue[] = [
            'Total Revenue By Card',
            (int)$total_revenue_by_card,
        ];
        $total_revenue_by_cash = Order::where('payment_type','cash_on_delivery')->sum('grand_total');
        $data_revenue[] = [
            'Total Revenue By Cash',
            (int)$total_revenue_by_cash,
        ];
        $status_shipping = OrderDetail::groupBy('delivery_status')->select('delivery_status', DB::raw('count(*) as total'))->get();
        foreach($status_shipping as $each_status_shipping)
        {
            $shipping_status[] = [
                ucfirst($each_status_shipping->delivery_status),
                (int)$each_status_shipping->total,
            ];
        }

        $data_product = Products::groupBy('name')->selectRaw('*, sum(current_stock) as quantity')->orderBy('quantity','desc')->get();
        foreach($data_product as $each_data_product)
        {
            $quantity_product[] = [
                ucfirst($each_data_product->name),
                (int)$each_data_product->quantity,
            ];
        }
        return view('admin.dashboard',
            [
                'customer' =>$customer,
                'seller' =>$seller,
                'shipper_data' =>$shipper_data,
                'product' =>$product,
                'enterprise' =>$enterprise,
                'data_revenue' =>$data_revenue,
                'shipping_status' =>$shipping_status,
                'quantity_product' =>$quantity_product,
            ]    
        );
    }
}
