<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\Assignment;

class SiasDemoSeeder extends Seeder
{
    public function run()
    {
        // Ensure demo user exists
        $user = User::updateOrCreate(
            ['email' => 'demo.student@skillup.test'],
            ['name' => 'Demo Student', 'password' => Hash::make('demo1234'), 'role' => 'student']
        );

        // Create or find a course
        $course = Course::first() ?? Course::factory()->create();

        // Enroll the demo user
        Enrollment::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['status' => 'active', 'enrolled_at' => now(), 'year_level' => 1]
        );

        // Create an assignment and submission
        $assignment = Assignment::factory()->create(['course_id' => $course->id]);
        Submission::factory()->create(['assignment_id' => $assignment->id, 'user_id' => $user->id, 'grade' => 88]);

        // Create a sample announcement if table exists
        if (\Schema::hasTable('announcements')) {
            DB::table('announcements')->insert([
                'title' => 'Welcome demo student',
                'message' => 'This is a demo announcement for the student dashboard.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create an attendance record if table exists
        if (\Schema::hasTable('attendances')) {
            DB::table('attendances')->insert([
                'user_id' => $user->id,
                'attended_at' => now(),
                'present' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
