<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Farmatika',
            'role'=> 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Ganti dengan password kuat
        ]);
        User::create([
            'name' => 'Apoteker Farmatika',
            'role'=> 'apoteker',
            'email' => 'apoteker@gmail.com',
            'password' => Hash::make('password'), // Ganti dengan password kuat
        ]);
    }
}
