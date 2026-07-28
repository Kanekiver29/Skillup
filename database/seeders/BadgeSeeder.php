<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Module Master',
                'slug' => 'module-master',
                'description' => 'Completed all quizzes in a module with a passing score.',
                'icon' => 'fa-puzzle-piece',
                'color' => '#10b981',
                'type' => 'module_completion',
            ],
            [
                'name' => 'Quiz Perfectionist',
                'slug' => 'quiz-perfectionist',
                'description' => 'Achieved a perfect 100% score on a quiz.',
                'icon' => 'fa-star',
                'color' => '#f59e0b',
                'type' => 'quiz_perfect',
            ],
            [
                'name' => 'Course Champion',
                'slug' => 'course-champion',
                'description' => 'Completed all modules and quizzes in an entire course.',
                'icon' => 'fa-graduation-cap',
                'color' => '#8b5cf6',
                'type' => 'course_completion',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['slug' => $badge['slug']],
                $badge
            );
        }
    }
}
