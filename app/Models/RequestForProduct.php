<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'shop_id',
        'buyer_id',
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
}
