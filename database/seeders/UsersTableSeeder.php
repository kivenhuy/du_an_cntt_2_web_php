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
    }
}
