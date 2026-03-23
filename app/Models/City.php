<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'city_name',
        'city_code',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function district()
    {
        return $this->hasMany(District::class,'city_id','id');
    }
}
