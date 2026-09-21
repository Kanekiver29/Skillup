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
        $accounts = [
            [
                'email' => 'admin@skillup.test',
                'name' => 'Admin User',
                'password' => 'admin1234?',
                'is_admin' => true,
                'role' => 'admin',
            ],
            [
                'email' => 'superadmin@skillup.test',
                'name' => 'Super Admin',
                'password' => 'superadmin1234?',
                'is_admin' => true,
                'role' => 'admin',
            ],
            [
                'email' => 'siasadmin@skillup.test',
                'name' => 'SIAS Admin',
                'password' => 'siasadmin1234?',
                'is_admin' => true,
                'role' => 'sias_admin',
            ],
            [
                'email' => 'staff@skillup.test',
                'name' => 'Staff User',
                'password' => 'staff1234?',
                'is_admin' => false,
                'role' => 'staff',
                'staff_type' => 'teacher',
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'is_admin' => $account['is_admin'],
                    'role' => $account['role'],
                    'staff_type' => $account['staff_type'] ?? null,
                ]
            );

            echo "Account created/updated: {$user->email} ({$user->role})\n";
        }
    }
}
