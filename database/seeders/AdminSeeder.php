<?php

namespace Database\Seeders;

use App\Models\User;  // Đảm bảo rằng bạn đã import User model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Tạ Hũu Thành',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
