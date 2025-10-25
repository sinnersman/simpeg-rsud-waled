<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => 'superadmin',
            'password' => Hash::make('password'), // You should change this to a strong password in production
        ]);

        User::create([
            'name' => 'Staff User',
            'username' => 'staff',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
        ]);
    }
}
