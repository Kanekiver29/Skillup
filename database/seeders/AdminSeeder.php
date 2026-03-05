<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the admin user (idempotent)
        $adminEmail = 'admin@skillup.test';

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin1234?'),
                'is_admin' => true,
            ]
        );

        echo "Admin user created/updated: {$adminEmail}\n";
    }
}
