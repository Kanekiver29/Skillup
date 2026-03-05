<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        $title = $this->faker->sentence(4);
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000,9999),
            'short_description' => $this->faker->paragraph,
            'description' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->word,
            'level' => $this->faker->randomElement(['Beginner','Intermediate','Advanced']),
            'duration_hours' => $this->faker->randomFloat(1, 1, 20),
            'instructor_name' => $this->faker->name,
            'instructor_title' => $this->faker->jobTitle,
            'image_url' => null,
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'students_count' => 0,
            'is_published' => true,
        ];
    }
}