<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $appends =['all_shipping_price','all_amount','amount_price'];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function getAllShippingPriceAttribute()
    {
        return single_price($this->orderDetails->sum('shipping_cost'));
    }

    public function getAllAmountAttribute()
    {
        return single_price($this->grand_total);
    }

    public function getAmountPriceAttribute()
    {
        return single_price($this->grand_total - $this->orderDetails->sum('shipping_cost'));
    }

    public function getUserDetailAttribute()
    {
        return $this->user;
    }
}
