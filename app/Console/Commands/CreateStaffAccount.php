<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateStaffAccount extends Command
{
    protected $signature = 'app:create-staff {--type=teacher : Staff type (instructor, teacher, moderator, content_manager, support)} {--admin : Create an admin account instead}';

    protected $description = 'Create a staff or admin account';

    public function handle()
    {
        $isAdmin = $this->option('admin');

        if ($isAdmin) {
            $email = 'admin@skillup.com';
            $existing = User::where('email', $email)->first();

            if ($existing) {
                // Reset the password so it works
                $existing->update([
                    'password' => Hash::make('admin1234'),
                    'is_admin' => true,
                    'role' => 'admin',
                ]);
                $this->info("Admin account reset!");
            } else {
                User::create([
                    'name' => 'Admin',
                    'email' => $email,
                    'password' => Hash::make('admin1234'),
                    'is_admin' => true,
                    'role' => 'admin',
                ]);
                $this->info("Admin account created!");
            }

            $this->table(['Field', 'Value'], [
                ['Name', 'Admin'],
                ['Email', $email],
                ['Password', 'admin1234'],
                ['Role', 'admin'],
                ['is_admin', 'true'],
            ]);
            return;
        }

        $type = $this->option('type');
        $email = 'staff.' . $type . '@skillup.com';

        $existing = User::where('email', $email)->first();
        if ($existing) {
            $this->info("Account already exists: {$existing->email} (role: {$existing->role}, type: {$existing->staff_type})");
            return;
        }

        $user = User::create([
            'name' => ucfirst($type) . ' Staff',
            'email' => $email,
            'password' => Hash::make('staff1234'),
            'role' => 'staff',
            'staff_type' => $type,
        ]);

        $this->info("Staff account created!");
        $this->table(['Field', 'Value'], [
            ['Name', $user->name],
            ['Email', $user->email],
            ['Password', 'staff1234'],
            ['Role', $user->role],
            ['Type', $user->staff_type],
        ]);
    }
}
