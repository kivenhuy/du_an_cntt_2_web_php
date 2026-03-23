<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    protected $table = 'carriers';
    use HasFactory;

    public function carrier_ranges(){
    	return $this->hasMany(CarrierRange::class);
    }
    
    public function carrier_range_prices(){
    	return $this->hasMany(CarrierRangePrice::class);
    }

    public function getNameBillingAttribute()
    {
        $data = "";
        if($this->carrier_ranges->first())
        {
            $data =$this->carrier_ranges->first()->billing_type;
        }
        return $data;
    }

    public function getMaxQuantityAttribute()
    {
        $data = "";
        if($this->carrier_ranges->first())
        {
            $data =$this->carrier_ranges->first()->delimiter2;
        }
        return $data;
    }

    public function getShippingPriceAttribute()
    {
        $data = 0;
        if($this->carrier_range_prices)
        {
            $data =$this->carrier_range_prices->first()->price;
        }
        return single_price($data);
    }
    public function getShippingPriceNormalAttribute()
    {
        $data = 0;
        if($this->carrier_range_prices)
        {
            $data =$this->carrier_range_prices->first()->price;
        }
        return ($data);
    }

    
}
