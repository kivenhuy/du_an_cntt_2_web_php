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
}
