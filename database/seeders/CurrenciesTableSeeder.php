<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::create([
            'name'=>'Vietnamese Dong',
            'symbol'=>'đ',
            'exchange_rate'=>1,
            'status'=>1,
            'code'=>'VND'
        ]);
    }
}
