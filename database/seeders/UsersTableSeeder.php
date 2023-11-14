<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>"Huy Le",
            'user_type'=>"admin",
            'email'=>"lebuuanhhuyle@gmail.com", 
            'password'=>"Kivenhuy123@", 
            'country'=>1, 
            'city'=>1, 
            'district'=>1, 
            'ward'=>1, 
            'phone'=>"0931657765", 
            'address'=>"639 Nguyễn Trãi"
        ]);

        User::create([
            'name'=>"buyer 01",
            'user_type'=>"customer",
            'email'=>"customer01@gmail.com", 
            'password'=>"12345678", 
            'country'=>2, 
            'city'=>2, 
            'district'=>2, 
            'ward'=>2, 
            'phone'=>"0123468741", 
            'address'=>"45 Nguyễn Trãi"
        ]);

        User::create([
            'name'=>"Seller 01",
            'user_type'=>"seller",
            'email'=>"seller01@gmail.com", 
            'password'=>"12345678", 
            'country'=>3, 
            'city'=>3, 
            'district'=>3, 
            'ward'=>3, 
            'phone'=>"0987666555", 
            'address'=>"123 bông sao"
        ]);

    }
}
