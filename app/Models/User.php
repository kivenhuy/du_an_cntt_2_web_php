<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_type',
        'email', 
        'password', 
        'country', 
        'city', 
        'district', 
        'ward', 
        'phone', 
        'address',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function enterprise_detail()
    {
        return $this->hasOne(EnterpriseDetails::class);
    }
    
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function request_products()
    {
        return $this->hasMany(RequestForProduct::class,'buyer_id','id');
    }
}
