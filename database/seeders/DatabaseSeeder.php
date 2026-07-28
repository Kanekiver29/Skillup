<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user for local/dev use
        User::updateOrCreate(
            ['email' => 'admin@skillup.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin1234?'),
                'is_admin' => true,
            ]
        );

        // Create a staff admin user (Admin with staff permissions)
        User::updateOrCreate(
            ['email' => 'staffadmin@skillup.test'],
            [
                'name' => 'Staff Admin',
                'password' => Hash::make('staffadmin1234?'),
                'is_admin' => true,
                'staff_type' => 'content_manager',
            ]
        );

        // Create a staff user (Teacher)
        User::updateOrCreate(
            ['email' => 'staff@skillup.test'],
            [
                'name' => 'Staff Teacher',
                'password' => Hash::make('staff1234?'),
                'is_admin' => false,
                'staff_type' => 'teacher',
            ]
        );

        // Create an instructor account (staff_type 'teacher' standard)
        User::updateOrCreate(
            ['email' => 'instructor@skillup.test'],
            [
                'name' => 'Instructor One',
                'password' => Hash::make('instructor1234?'),
                'is_admin' => false,
                'staff_type' => 'teacher',
                'role' => 'staff',
            ]
        );

        // Create an additional staff user (Teacher)
        User::updateOrCreate(
            ['email' => 'staff2@skillup.test'],
            [
                'name' => 'Staff Two',
                'password' => Hash::make('staff2345?'),
                'is_admin' => false,
                'staff_type' => 'teacher',
            ]
        );

        // Create a regular user
        User::updateOrCreate(
            ['email' => 'user@skillup.test'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('user1234?'),
                'is_admin' => false,
            ]
        );

        // Seed additional demo users
        User::factory(10)->create();

        // Run course seeder
        $this->call(CourseSeeder::class);

        // Run module and quiz seeders
        $this->call(ModuleSeeder::class);
        $this->call(QuizSeeder::class);
    }
}

