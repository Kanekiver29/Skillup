<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('prevents non-admins from accessing admin pages', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get(route('admin.courses.index'))
        ->assertStatus(403);
});

it('allows admins to view courses index and create course', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->get(route('admin.courses.index'));
    $response->assertStatus(200);

    // create a course via POST
    $data = [
        'title' => 'Test Course',
        'short_description' => 'short',
        'description' => 'desc',
        'category' => 'Cat',
        'level' => 'Beginner',
        'duration_hours' => 1,
        'instructor_name' => 'Instr',
        'instructor_title' => 'Title',
        'is_published' => true,
    ];

    $this->actingAs($admin)
        ->post(route('admin.courses.store'), $data)
        ->assertRedirect(route('admin.courses.index'));

    $this->assertDatabaseHas('courses', ['title' => 'Test Course']);
});

it('admin can view enrollments list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $student = User::factory()->create();
    $course = Course::factory()->create();
    Enrollment::create(['user_id' => $student->id, 'course_id' => $course->id]);

    $this->actingAs($admin)
        ->get(route('admin.enrollments.index'))
        ->assertStatus(200)
        ->assertSee($student->name)
        ->assertSee($course->title);
});

it('admin account page shows admins', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin)
        ->get(route('admin.admins'))
        ->assertStatus(200)
        ->assertSee($admin->email);
});
