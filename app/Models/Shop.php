<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }       

    public function getImgLogoAttribute()
    {
        $data =uploaded_asset($this->logo);
        return $data;
    }

    public function getImgBannerAttribute()
    {
        $data =uploaded_asset($this->logo);
        return $data;
    }
}
