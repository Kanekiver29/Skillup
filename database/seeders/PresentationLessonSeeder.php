<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;

class PresentationLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the first published course and its first module
        $course = Course::where('is_published', true)->first();
        if (!$course) {
            $this->command->info('No published course found.');
            return;
        }
        $module = $course->modules()->where('is_published', true)->first();
        if (!$module) {
            $this->command->info('Course has no published modules.');
            return;
        }

        // Create a presentation lesson
        $title = 'Sample Presentation Lesson';
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        while (Lesson::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module->id,
            'title' => $title,
            'slug' => $slug,
            'description' => 'A sample presentation lesson for testing.',
            // Using a placeholder path; ensure the file exists if needed.
            'content' => 'presentations/sample.pptx',
            'video_url' => null,
            'duration_minutes' => 15,
            'order' => $module->lessons()->max('order') + 1,
            'is_published' => true,
        ]);

        $this->command->info('Presentation lesson created successfully.');
    }
}
