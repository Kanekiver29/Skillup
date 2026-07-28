<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTeacherAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Configure via environment or defaults
        $email = env('TEACHER_EMAIL', 'teacher@example.com');
        $username = env('TEACHER_USERNAME', 'teacher');
        $password = env('TEACHER_PASSWORD', 'Teacher123!');
        $name = env('TEACHER_NAME', 'Default Teacher');

        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = new User();
            $user->email = $email;
        }

        // Set only columns that exist to avoid SQL errors on varying schemas
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'name')) {
            $user->name = $name;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'username')) {
            $user->username = $username;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'role')) {
            // Use 'staff' role with a staff_type of 'teacher' to match AuthController expectations
            $user->role = 'staff';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'staff_type')) {
                $user->staff_type = 'teacher';
            }
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'department')) {
            $user->department = $user->department ?? 'Training';
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'assigned_course_id')) {
            $user->assigned_course_id = $user->assigned_course_id ?? null;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'password')) {
            $user->password = Hash::make($password);
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_active')) {
            $user->is_active = true;
        }

        $user->save();

        $this->command->info("Teacher account ensured: {$email} (username: {$username})");
        $this->command->warn("Password: {$password} — change it after first login.");
    }
}
