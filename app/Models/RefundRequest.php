<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'buyer_id','id');
    }

    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class,'order_detail_id','id');
    }

    public function getImgRefundAttribute()
    {
        $data =uploaded_asset($this->img_proof);
        return $data;
    }
}
