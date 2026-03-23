<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $appends = ['product_name'];
    protected $fillable = ['product_id', 'variant', 'sku', 'price', 'qty'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function getProductNameAttribute()
    {
        $data =Products::find($this->product_id);
        if($data)
        {   
            return $data->name;
        }
        return "";
    }
}
