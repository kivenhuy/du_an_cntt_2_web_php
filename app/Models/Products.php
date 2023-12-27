<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'photos',
        'thumbnail_img',
        'tags',
        'description',
        'unit_price',
        'purchase_price',
        'variant_product',
        'attributes',
        'choice_options',
        'approved',
        'current_stock',
        'unit',
        'weight',
        'min_qty',
        'low_stock_quantity',
        'discount',
        'discount_type',
        'discount_start_date',
        'discount_end_date',
        'shipping_type',
        'est_shipping_days',
        'num_of_sale',
        'meta_img',
        'slug',
        'short_shelf_life',
        'published',
        'rating',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product_stock()
    {
        return $this->hasOne(ProductStock::class,'product_id','id');
    }

    public function getImgUrlAttribute()
    {
        $data =uploaded_asset($this->thumbnail_img);
        return $data;
    }

    public function getQtyAttribute()
    {
        $data =($this->product_stock);
        return $data->qty;
    }

}
