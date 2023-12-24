<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivation extends Model
{
    use HasFactory;
    protected $connection = 'mysql_second';

    protected $fillable =[
        'farmer_id',
        'cultivation_name',
        'harvest_Season',
        'crop_variety',
        'sowing_Date',
        'expected_Date_of_Harvest_after_Sowing',
        'est_Yield',
        'seed_Quantity_unit',
        'updated_at',
        'created_at',
    ];
}
