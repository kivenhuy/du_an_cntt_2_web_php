<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $appends = ['product_name','each_price','shop_name'];
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
}
