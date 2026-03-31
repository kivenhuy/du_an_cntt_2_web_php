<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Products;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Http;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Nhãn tiếng Việt cho trạng thái giao hàng (bảng orders). */
    private static function deliveryStatusLabel(?string $status): string
    {
        return match ($status) {
            'waiting' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'on_delivery' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            null, '' => '—',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }

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

        // Doanh thu: đơn đã thanh toán
        $revenue_paid_total = (float) Order::where('payment_status', 'paid')->sum('grand_total');
        $now = Carbon::now();
        $revenue_month = (float) Order::where('payment_status', 'paid')
            ->whereYear('order_date', $now->year)
            ->whereMonth('order_date', $now->month)
            ->sum('grand_total');
        $orders_count = Order::count();

        $total_revenue_by_card = Order::where('payment_type','bank_payment')->sum('grand_total');
        $data_revenue[] = [
            'Thẻ / chuyển khoản',
            (int)$total_revenue_by_card,
        ];
        $total_revenue_by_cash = Order::where('payment_type','cash_on_delivery')->sum('grand_total');
        $data_revenue[] = [
            'COD',
            (int)$total_revenue_by_cash,
        ];
        // Trạng thái đơn hàng theo từng đơn (orders), không gom theo dòng order_detail
        $status_shipping = Order::query()
            ->select('delivery_status', DB::raw('count(*) as total'))
            ->groupBy('delivery_status')
            ->orderByDesc('total')
            ->get();
        foreach ($status_shipping as $each_status_shipping) {
            $shipping_status[] = [
                self::deliveryStatusLabel($each_status_shipping->delivery_status),
                (int) $each_status_shipping->total,
            ];
        }

        // Tổng tồn kho (current_stock) gom theo tên — cùng nghĩa “còn lại N” trên trang chi tiết
        $data_product = Products::query()
            ->selectRaw('name, SUM(current_stock) as quantity')
            ->groupBy('name')
            ->orderByDesc('quantity')
            ->get();
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
                'revenue_paid_total' => $revenue_paid_total,
                'revenue_month' => $revenue_month,
                'orders_count' => $orders_count,
            ]
        );
    }
}
