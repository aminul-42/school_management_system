<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);

        // Create Students
        User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@armenglishacademy.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Mike Johnson',
            'email' => 'mike.johnson@armenglishacademy.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
        ]);
    }
}