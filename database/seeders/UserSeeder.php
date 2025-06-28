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
            'name' => 'Admin User',
            'email' => 'admin@admin.com', // Ganti dengan email admin yang Anda inginkan
            'password' => Hash::make('admin'), // Ganti dengan password admin yang Anda inginkan
        ]);
    }
}
