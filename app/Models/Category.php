<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Products::class,'category_id','id');
    }


    public function product_stock()
    {

        return $this->hasManyThrough(
            ProductStock::class, 
            Products::class,
            'category_id',// Foreign key on the environments table...
            'product_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id');
    }
}
