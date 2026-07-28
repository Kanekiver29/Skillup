<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can mark a module as complete via the route', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create(['is_published' => true]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Sample Module',
        'slug' => 'sample-module',
        'description' => 'Sample module description',
        'is_published' => true,
        'order' => 1,
    ]);
    Lesson::create([
        'module_id' => $module->id,
        'course_id' => $course->id,
        'title' => 'Sample Lesson',
        'slug' => 'sample-lesson',
        'description' => 'Sample lesson description',
        'content' => 'Sample content',
        'duration_minutes' => 5,
        'is_published' => true,
        'order' => 1,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('modules.markComplete', [$course->slug, $module->slug]));

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $this->assertDatabaseHas('enrollments', [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

test('guests cannot mark a module as complete', function () {
    $course = Course::factory()->create(['is_published' => true]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Sample Module',
        'slug' => 'sample-module',
        'description' => 'Sample module description',
        'is_published' => true,
        'order' => 1,
    ]);

    $response = $this->post(route('modules.markComplete', [$course->slug, $module->slug]));

    $response->assertRedirectContains('/login');
});
