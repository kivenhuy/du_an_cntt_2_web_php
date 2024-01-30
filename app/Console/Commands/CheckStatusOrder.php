<?php

namespace App\Console\Commands;

use App\Models\OrderDetail;
use App\Models\ShippingHistory;
use App\Models\User;
use App\Notifications\OrderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckStatusOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now()->addHour(2);
        $order_details_1 = OrderDetail::with('order')->orderByDesc('created_at')
        ->where('shipping_type','Fast Shipping')
        ->WhereDate('created_at','<=',$now)
        ->whereTime('created_at', '<=',$now->toTimeString())
        ->where('shipping_date',null)
        ->where('delivery_status','!=','fail')
        ->get();

        foreach($order_details_1 as $each_order_details_1)
        {
            $time_remaining = strtotime($each_order_details_1->created_at)+9*60*60 ;
            $time_now = strtotime(Carbon::now()->addHours(7));
            if($time_remaining < $time_now)
            {
                $each_order_details_1->delivery_status = 'fail';
                $each_order_details_1->save();
            }
            
        }


        $now_2 = Carbon::now()->addHour(9);
        // dd($now);
        $order_details_2 = OrderDetail::with('order')->orderByDesc('created_at')
        ->where('shipping_type','Fast Shipping')
        ->WhereDate('shipping_date','<=',$now_2)
        ->whereTime('shipping_date', '<=',$now_2->toTimeString())
        ->where('delivery_status','!=','fail')
        ->get();

        foreach($order_details_2 as $each_order_details_2)
        {
            $time_remaining = strtotime($each_order_details_2->shipping_date);
            $time_now = strtotime(Carbon::now()->addHours(7));
            if($time_remaining < $time_now)
            {
                $each_order_details_2->delivery_status = 'fail';
                $each_order_details_2->save();
            }
            
        }

        $now_3 = Carbon::now()->addHour(7);
        $order_details_3 = OrderDetail::with('order')->orderByDesc('created_at')
        ->WhereDate('shipping_date','<=',$now_3)
        ->whereTime('shipping_date', '<=',$now_3->toTimeString())
        ->where('shipping_type','Normal Shipping')
        ->where('delivery_status','!=','fail')
        ->get();

        foreach($order_details_3 as $each_order_details_3)
        {
            $time_remaining = strtotime($each_order_details_3->shipping_date);
            $time_now = strtotime(Carbon::now()->addHours(7));
            if($time_remaining < $time_now)
            {
                $each_order_details_3->delivery_status = 'fail';
                $each_order_details_3->save();
                if($each_order_details_3)
                {
                    $shipping_history = new ShippingHistory();
                    $shipping_history->order_detail_id = $each_order_details_3->id;
                    $shipping_history->shipper_id = 0;
                    $shipping_history->shipper_name = "";
                    $shipping_history->photo = "";
                    $shipping_history->status = "fail";
                    $shipping_history->save();
                    if($shipping_history)
                    {
                        $customer = User::find($each_order_details_3->order->customer_id);
                        Notification::send($customer, new OrderNotification($shipping_history));
                    }
                }
            }
            
        }
    
    }
}
