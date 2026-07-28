<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ExcelReportTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@skillup.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'is_admin' => true,
                'role' => 'admin',
                'age' => 32,
                'birthday' => Carbon::parse('1992-05-15'),
                'location' => 'New York, USA',
                'profile_public' => true,
            ]
        );

        // Create test students with age and birthday
        $students = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'age' => 22,
                'birthday' => Carbon::parse('2002-03-20'),
                'location' => 'San Francisco, CA',
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'age' => 25,
                'birthday' => Carbon::parse('1999-07-10'),
                'location' => 'Los Angeles, CA',
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol@example.com',
                'age' => 23,
                'birthday' => Carbon::parse('2001-11-05'),
                'location' => 'Chicago, IL',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'age' => 26,
                'birthday' => Carbon::parse('1998-02-14'),
                'location' => 'Seattle, WA',
            ],
            [
                'name' => 'Emma Martinez',
                'email' => 'emma@example.com',
                'age' => 21,
                'birthday' => Carbon::parse('2003-09-28'),
                'location' => 'Austin, TX',
            ],
            [
                'name' => 'Frank Brown',
                'email' => 'frank@example.com',
                'age' => 24,
                'birthday' => Carbon::parse('2000-06-17'),
                'location' => 'Boston, MA',
            ],
            [
                'name' => 'Grace Lee',
                'email' => 'grace@example.com',
                'age' => 23,
                'birthday' => Carbon::parse('2001-12-08'),
                'location' => 'New York, NY',
            ],
            [
                'name' => 'Henry Taylor',
                'email' => 'henry@example.com',
                'age' => 27,
                'birthday' => Carbon::parse('1997-01-22'),
                'location' => 'Denver, CO',
            ],
            [
                'name' => 'Ivy Anderson',
                'email' => 'ivy@example.com',
                'age' => 22,
                'birthday' => Carbon::parse('2002-04-11'),
                'location' => 'Miami, FL',
            ],
            [
                'name' => 'Jack Thompson',
                'email' => 'jack@example.com',
                'age' => 25,
                'birthday' => Carbon::parse('1999-08-30'),
                'location' => 'Portland, OR',
            ],
        ];

        foreach ($students as $studentData) {
            User::firstOrCreate(
                ['email' => $studentData['email']],
                array_merge($studentData, [
                    'password' => Hash::make('password123'),
                    'is_admin' => false,
                    'role' => 'student',
                    'profile_public' => true,
                ])
            );
        }

        // Create test courses if they don't exist
        $courses = Course::firstOrCreate(
            ['slug' => 'intro-to-web-development'],
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript',
                'category' => 'Web Development',
                'level' => 'Beginner',
                'instructor_name' => 'Prof. Smith',
                'is_published' => true,
            ]
        );

        Course::firstOrCreate(
            ['slug' => 'advanced-php'],
            [
                'title' => 'Advanced PHP Development',
                'description' => 'Master Laravel and modern PHP patterns',
                'category' => 'Backend Development',
                'level' => 'Advanced',
                'instructor_name' => 'Prof. Johnson',
                'is_published' => true,
            ]
        );

        Course::firstOrCreate(
            ['slug' => 'data-science-101'],
            [
                'title' => 'Data Science 101',
                'description' => 'Introduction to data analysis and visualization',
                'category' => 'Data Science',
                'level' => 'Beginner',
                'instructor_name' => 'Prof. Davis',
                'is_published' => true,
            ]
        );

        // Create enrollments
        $allCourses = Course::where('is_published', true)->get();
        $allStudents = User::where('is_admin', false)->get();

        foreach ($allStudents as $student) {
            $coursesToEnroll = $allCourses->random(rand(1, 3));
            foreach ($coursesToEnroll as $course) {
                Enrollment::firstOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'progress' => rand(0, 100),
                        'completed' => rand(0, 1),
                    ]
                );
            }
        }

        echo "✅ Test data seeded successfully!\n";
        echo "📊 Created " . User::where('is_admin', false)->count() . " test students\n";
        echo "📚 Created " . Course::count() . " test courses\n";
        echo "📝 Created " . Enrollment::count() . " test enrollments\n";
    }
}
