<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class EnsureInstructorAccount extends Command
{
    protected $signature = 'app:ensure-instructor {email=instructor@skillup.test} {password=instructor1234?}';

    protected $description = 'Create or reset the instructor account';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Instructor',
                'password' => Hash::make($password),
                'is_admin' => false,
                'role' => 'staff',
                'staff_type' => 'teacher',
            ]
        );

        $this->info("Instructor account ensured: {$user->email}");
        $this->table(['Field','Value'], [
            ['Email', $user->email],
            ['Password', $password],
            ['Role', $user->role],
            ['Staff Type', $user->staff_type],
        ]);
    }
}
