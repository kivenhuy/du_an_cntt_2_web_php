<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_name',
        'country_code',
    ];

    public function city()
    {
        return $this->hasMany(City::class,'country_id','id');
    }

    public function province()
    {
        return $this->hasMany(Province::class,'country_id','id');
    }
}
