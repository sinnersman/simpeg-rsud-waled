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
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'superadmin',
                'password' => Hash::make('password'), // You should change this to a strong password in production
            ]
        );

        User::firstOrCreate(
            ['username' => 'staff'],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'role' => 'staff',
                'password' => Hash::make('password'),
            ]
        );
    }
}
