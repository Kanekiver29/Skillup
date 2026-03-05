<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        if ($courses->isEmpty()) {
            $this->command->warn('No courses found. Please seed courses first.');
            return;
        }

        foreach ($courses as $course) {
            // Create 3-5 modules per course
            $numberOfModules = random_int(3, 5);

            for ($i = 1; $i <= $numberOfModules; $i++) {
                $title = "Module " . $i . ": " . match ($i) {
                    1 => "Fundamentals & Basics",
                    2 => "Intermediate Concepts",
                    3 => "Advanced Techniques",
                    4 => "Practical Applications",
                    5 => "Capstone Project",
                    default => "Topics & Discussion"
                };

                Module::create([
                    'course_id' => $course->id,
                    'title' => $title,
                    'slug' => Str::slug($course->slug . '-' . $title),
                    'description' => "Learn the essential concepts of " . strtolower($title) . " in {$course->title}. This module covers everything you need to know to master this topic.",
                    'order' => $i,
                    'is_published' => true,
                ]);
            }
        }

        $this->command->info('Modules seeded successfully!');
    }
}
