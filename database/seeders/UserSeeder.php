<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin fadel',
            'email' => 'fadel@admin.com',
            'password' => Hash::make('admin'),
        ]);
        User::create([
            'name' => 'Admin dandy',
            'email' => 'dandy@admin.com', 
            'password' => Hash::make('admin'), 
        ]);
    }
}
