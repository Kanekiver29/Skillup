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
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@skillup.test',
            'password' => 'admin1234',
            'is_admin' => true,
        ]);
          //Create a for the user
         User::factory()->create([
            'name' => '(user_name)',
            'email' => '(user_email)',
            'password' => '(user_password)',
        ]);

        // Seed additional demo users
        User::factory(10)->create();

        // Run course seeder
        $this->call(CourseSeeder::class);

        // Run module and quiz seeders
        $this->call(ModuleSeeder::class);
        $this->call(QuizSeeder::class);
    }
}

