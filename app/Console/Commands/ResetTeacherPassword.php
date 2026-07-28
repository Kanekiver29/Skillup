<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ResetTeacherPassword extends Command
{
    protected $signature = 'reset:teacher {--email= : email of teacher} {--password= : new password}';
    protected $description = 'Reset teacher password and ensure account is active';

    public function handle()
    {
        $email = $this->option('email') ?: 'teacher@example.com';
        $password = $this->option('password') ?: 'Teacher123!';

        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error("User not found: {$email}");
            return 1;
        }

        if (Schema::hasColumn('users', 'password')) {
            $user->password = Hash::make($password);
        }
        if (Schema::hasColumn('users', 'is_active')) {
            $user->is_active = 1;
        }
        $user->save();

        $this->info("Password reset for {$email}. New password: {$password}");
        return 0;
    }
}
