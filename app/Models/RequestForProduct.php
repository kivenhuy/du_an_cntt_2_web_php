<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForProduct extends Model
{

    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_name',
        'shop_id',
        'buyer_id',
        'code',
        'from_date',
        'to_date',
        'code',
        'shipping_date',
        'distance_between_shipping_date',
        'quantity',
        'unit',
        'price',
        'status',
    ];

    public function getSellerNameAttribute()
    {
        if($this->shop_id != 0)
        {
            $data =Shop::find($this->shop_id)->name;
        }
        else
        {
            $data = "";
        }
        return $data;
    }

    public function getUnitPriceAttribute()
    {
        $data =single_price($this->price);
        return $data;
    }

    public function user()  {
        return $this->belongsTo(User::class,'buyer_id','id');
    }
}
