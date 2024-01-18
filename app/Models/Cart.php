<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function getShippingDateAttribute()
    {
        // $final_data = [];
        if($this->is_rfp != 0)
        {
            $data = RequestForProduct::find($this->is_rfp)->shipping_date;
            $data = json_decode($data);
        }
        
        return $data;
    }

    public function getProductNameAttribute()
    {
        $data = "";
        if($this->product_id != 0)
        {
            $data = Products::find($this->product_id)->name;
        }
        
        return $data;
    }

    public function getSellerNameAttribute()
    {
        $data = "";
        if($this->product_id != 0)
        {
            $data = User::find($this->owner_id)->name;
        }
        
        return $data;
    }

    public function getImgProductAttribute()
    {
        $data = "";
        if($this->product_id != 0)
        {
            $img_id = Products::find($this->product_id)->thumbnail_img;
            $data = env('ECOM_URL_PHOTO').Uploads::find($img_id)->file_name;
        }
        
        return $data;
    }

    public function getTotalPriceAttribute()
    {
        $data = single_price(0);
        if($this->product_id != 0 && $this->is_rfp !=0)
        {
            $product = Products::find($this->product_id);
            $data =single_price(cart_product_price($this, $product, false) * $this->quantity * count($this->shipping_date));
        }
        return $data;
    }

    public function getTotalPriceNormalAttribute()
    {
        $data = single_price(0);
        if($this->product_id != 0)
        {
            $product = Products::find($this->product_id);
            $data =(cart_product_price($this, $product, false) * $this->quantity);
        }
        return $data;
    }

    
}
