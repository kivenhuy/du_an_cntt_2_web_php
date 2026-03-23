<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $appends =['city_name','country_name','district_name'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getCityNameAttribute()
    {
        $data = $this->city->city_name;
        return $data;
    }

    public function getCountryNameAttribute()
    {
        $data = $this->country->country_name;
        return $data;
    }

    public function getDistrictNameAttribute()
    {
        $data = $this->district->district_name;
        return $data;
    }
}
