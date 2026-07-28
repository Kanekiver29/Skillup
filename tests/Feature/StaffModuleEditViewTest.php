<?php

use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

it('renders the staff module edit view', function () {
    $staff = User::factory()->create([
        'role' => 'staff',
        'is_admin' => false,
    ]);

    $course = Course::create([
        'title' => 'Course One',
        'slug' => Str::slug('Course One') . '-1',
        'short_description' => 'Test course',
        'description' => 'Test course description',
        'category' => 'Education',
        'level' => 'Beginner',
        'duration_hours' => 2,
        'instructor_name' => 'Instructor',
        'instructor_title' => 'Teacher',
        'image_url' => null,
        'rating' => 0,
        'students_count' => 0,
        'is_published' => true,
    ]);

    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Sample Module',
        'slug' => Str::slug('Sample Module'),
        'description' => 'Module description',
        'definition' => null,
        'example' => null,
        'order' => 1,
        'is_published' => true,
    ]);

    $response = $this->actingAs($staff)->get(route('staff.modules.edit', $module));

    $response->assertOk();
    $response->assertSee('Edit Module');
});
