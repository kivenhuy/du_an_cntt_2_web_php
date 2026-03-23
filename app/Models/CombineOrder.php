<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombineOrder extends Model
{
    use HasFactory;
    public function orders(){
    	return $this->hasMany(Order::class,'combined_order_id','id');
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
