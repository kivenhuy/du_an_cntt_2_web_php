<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $appends = ['product_name','each_price','shop_name','ship_his'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function shipping_history()
    {
        return $this->hasMany(ShippingHistory::class,'order_detail_id','id');
    }

    public function refund_requets()
    {
        return $this->hasOne(RefundRequest::class,'order_detail_id','id');
    }

    public function getShipHisAttribute()
    {
        $data = ShippingHistory::where('order_detail_id',$this->id)->count();
        return $data;
    }

    public function getEachPriceAttribute()
    {
        $data = single_price($this->price);
        return $data;
    }

    public function getProductNameAttribute()
    {
        $data = "";
        $product_data = Products::find($this->product_id);
        if($product_data)
        {
            $data = $product_data->name;
        }
        
        return $data;
    }

    public function getShopNameAttribute()
    {
        $data = "";
        $user_data = User::find($this->seller_id);
        if($user_data)
        {
            $data = $user_data->shop->name;
        }
        
        return $data;
    }

    public function getShopAddressAttribute()
    {
        $data = "";
        $user_data = User::find($this->seller_id);
        $city_name = City::find($user_data->city)->city_name;
        $country_name = Country::find($user_data->country)->country_name;
        $district_name = District::find($user_data->district)->district_name;
        // $user_name = User::find($user_data->user_id)->name;
        $str = $user_data->name.', '.$user_data->phone.', '.$user_data->address.', '.$user_data->ward.', '.$district_name.', '.$city_name.', '.$country_name;
        $data = $str;        
        return $data;
    }
}
