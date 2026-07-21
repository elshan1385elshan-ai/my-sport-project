<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'مدیر سایت',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        User::create([
            'name' => 'مدیر سایت',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
