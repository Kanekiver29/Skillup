<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a course from the modal form payload', function () {
    $staff = User::factory()->create([
        'role' => 'staff',
        'staff_type' => 'content_manager',
    ]);

    $response = $this->actingAs($staff)->post(route('staff.courses.store'), [
        'course_title' => 'Modal Course',
        'course_code' => 'MC101',
        'units' => '3.5',
        'instructor' => 'Dr. Example',
        'department' => 'Engineering',
        'status' => 'draft',
        'description' => 'Created through the modal form.',
    ]);

    $response->assertRedirect(route('staff.courses.index'));

    $this->assertDatabaseHas('courses', [
        'title' => 'Modal Course',
        'description' => 'Created through the modal form.',
        'instructor_name' => 'Dr. Example',
        'category' => 'Engineering',
        'level' => 'Beginner',
        'duration_hours' => 3.5,
        'is_published' => false,
    ]);
});
