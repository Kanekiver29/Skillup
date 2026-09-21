<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiasAccountSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'email' => env('SIAS_ADMIN_EMAIL', 'siasadmin@skillup.test'),
                'name' => env('SIAS_ADMIN_NAME', 'SIAS Admin'),
                'password' => env('SIAS_ADMIN_PASSWORD', 'SiasAdmin123!'),
                'role' => 'admin',
                'is_admin' => true,
            ],
            [
                'email' => env('SIAS_TEACHER_EMAIL', 'siasteacher@skillup.test'),
                'name' => env('SIAS_TEACHER_NAME', 'SIAS Teacher'),
                'password' => env('SIAS_TEACHER_PASSWORD', 'SiasTeacher123!'),
                'role' => 'staff',
                'staff_type' => 'teacher',
                'is_admin' => false,
            ],
            [
                'email' => env('SIAS_STUDENT_EMAIL', 'siasstudent@skillup.test'),
                'name' => env('SIAS_STUDENT_NAME', 'SIAS Student'),
                'password' => env('SIAS_STUDENT_PASSWORD', 'SiasStudent123!'),
                'role' => 'student',
                'is_admin' => false,
            ],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'role' => $account['role'],
                    'is_admin' => $account['is_admin'] ?? false,
                    'staff_type' => $account['staff_type'] ?? null,
                ]
            );

            $this->command->info('SIAS account created/updated: ' . $account['email']);
        }
    }
}
