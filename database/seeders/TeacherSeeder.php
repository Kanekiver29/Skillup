<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'teacher1@skillup.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'staff_type' => 'teacher',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::create([
            'name' => 'Jane Smith',
            'email' => 'teacher2@skillup.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'staff_type' => 'instructor',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::create([
            'name' => 'Robert Johnson',
            'email' => 'teacher3@skillup.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'staff_type' => 'teacher',
            'email_verified_at' => now(),
        ]);
    }
}
