<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows a teacher-facing student detail page for an enrolled student', function () {
    $teacher = User::factory()->create([
        'name' => 'Teacher Example',
        'role' => 'teacher',
        'email' => 'teacher@example.com',
    ]);

    $student = User::factory()->create([
        'name' => 'Student Example',
        'role' => 'student',
        'email' => 'student@example.com',
    ]);

    $course = Course::factory()->create([
        'title' => 'Intro to Laravel',
        'instructor_id' => $teacher->id,
        'instructor_name' => $teacher->name,
    ]);

    $enrollment = Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'progress' => 68,
        'status' => 'Active',
    ]);

    $response = $this->actingAs($teacher)->get(route('teacher.students.show', $enrollment->id));

    $response->assertOk();
    $response->assertSee('Student Overview');
    $response->assertSee('Student Example');
    $response->assertSee('Intro to Laravel');
});
