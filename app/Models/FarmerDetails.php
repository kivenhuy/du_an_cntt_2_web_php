<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerDetails extends Model
{
    use HasFactory;
    protected $connection = 'mysql_second';

    protected $fillable = [
        'staff_id',
        'user_id',
        'enrollment_date',
        'enrollment_place',
        'full_name',
        'phone_number',
        'country',  
        'province',
        'commune',
        'village',
        'lng',
        'lat',
        'gender',
        'farmer_code',
        'dob',
        'farmer_photo',
    ];
}
