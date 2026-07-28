<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixAdmin extends Command
{
    protected $signature = 'app:fix-admin';
    protected $description = 'Fix or restore the admin@skillup.test account';

    public function handle()
    {
        // Check if soft-deleted
        $trashed = User::withTrashed()->where('email', 'admin@skillup.test')->first();

        if ($trashed && $trashed->trashed()) {
            $trashed->restore();
            $trashed->update([
                'password' => Hash::make('admin1234'),
                'is_admin' => true,
                'role' => 'admin',
            ]);
            $this->info('Restored and reset admin@skillup.test');
        } elseif ($trashed) {
            $trashed->update([
                'password' => Hash::make('admin1234'),
                'is_admin' => true,
                'role' => 'admin',
            ]);
            $this->info('Reset password for admin@skillup.test');
        } else {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@skillup.test',
                'password' => Hash::make('admin1234'),
                'is_admin' => true,
                'role' => 'admin',
            ]);
            $this->info('Created admin@skillup.test');
        }

        $this->table(['Field', 'Value'], [
            ['Email', 'admin@skillup.test'],
            ['Password', 'admin1234'],
        ]);
    }
}
