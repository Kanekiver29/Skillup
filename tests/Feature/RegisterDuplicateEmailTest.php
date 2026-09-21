<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('student registration stores the selected course and creates the enrollment', function () {
    $course = Course::factory()->create();

    $response = $this->from('/register')->post('/register', [
        'name' => 'Student User',
        'email' => 'student@example.com',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
        'age' => 22,
        'birthday' => '2002-01-15',
        'address' => 'Student Address',
        'course_id' => $course->id,
        'terms' => 'on',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'student@example.com',
        'role' => 'student',
        'assigned_course_id' => $course->id,
    ]);
    $this->assertDatabaseHas('enrollments', [
        'user_id' => auth()->id(),
        'course_id' => $course->id,
        'status' => 'approved',
    ]);
    $this->assertTrue(Enrollment::where('user_id', auth()->id())->where('course_id', $course->id)->exists());
});

test('students are redirected to their assigned major course when visiting the courses page', function () {
    $user = User::factory()->create([
        'role' => 'student',
        'assigned_course_id' => null,
    ]);

    $course = Course::factory()->create([
        'is_published' => true,
        'slug' => 'computer-science',
    ]);

    $user->update(['assigned_course_id' => $course->id]);

    $response = $this->actingAs($user)->get('/courses');

    $response->assertRedirect(route('courses.show', $course->slug));
});

test('student login accepts either student id or email in SIAS login', function () {
    $user = User::factory()->create([
        'name' => 'Email Login User',
        'role' => 'student',
        'email' => 'student-email@example.com',
        'lrn' => 'STU-1002',
        'assigned_course_id' => null,
        'password' => bcrypt('Password123'),
    ]);

    $response = $this->from('/sias/login')->post('/sias/login', [
        'student_id' => 'student-email@example.com',
        'password' => 'Password123',
        'login_as' => 'student',
    ]);

    $response->assertRedirect(route('sias.student.dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('student login redirects to the designated course in their major using the student id', function () {
    $major = \App\Models\Major::create([
        'name' => 'Information Technology',
        'code' => 'IT-101',
        'description' => 'IT major',
        'is_active' => true,
    ]);

    $course = Course::factory()->create([
        'title' => 'Programming Fundamentals',
        'slug' => 'programming-fundamentals',
        'is_published' => true,
        'major_id' => $major->id,
        'is_primary' => true,
    ]);

    $user = User::factory()->create([
        'name' => 'Student Login User',
        'role' => 'student',
        'lrn' => 'STU-1001',
        'major_id' => $major->id,
        'assigned_course_id' => null,
        'password' => bcrypt('Password123'),
    ]);

    $response = $this->from('/sias/login')->post('/sias/login', [
        'student_id' => 'STU-1001',
        'password' => 'Password123',
        'login_as' => 'student',
    ]);

    $response->assertRedirect(route('courses.show', $course->slug));
    $this->assertAuthenticatedAs($user);
});

test('duplicate email registration shows validation error instead of crashing', function () {
    User::factory()->create([
        'email' => 'coffelover539@gmail.com',
    ]);

    $response = $this->from('/register')->post('/register', [
        'name' => 'Duplicate User',
        'email' => 'coffelover539@gmail.com',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
        'age' => 25,
        'birthday' => '2000-05-07',
        'address' => 'Test Address',
        'terms' => 'on',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('email');
    $this->assertDatabaseCount('users', 1);
});

test('duplicate student email during admin student creation shows validation error instead of crashing', function () {
    $admin = User::factory()->create([
        'email' => 'admin@example.com',
        'is_admin' => true,
        'role' => 'admin',
    ]);

    User::factory()->create([
        'email' => 'coffelover539@gmail.com',
        'role' => 'student',
    ]);

    $response = $this->actingAs($admin)
        ->from('/sias/admin/students')
        ->post('/sias/admin/students', [
            'name' => 'cj mamotos',
            'age' => 34,
            'email' => 'coffelover539@gmail.com',
            'student_id' => '23-21312',
            'password' => 'AdminCreate123',
            'desired_course' => 'IT',
        ]);

    $response->assertRedirect('/sias/admin/students');
    $response->assertSessionHasErrors('email');
    $this->assertDatabaseCount('users', 2);
});

test('student certificate index renders completed certificates without crashing', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();

    Enrollment::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'completed' => true,
        'completed_at' => now(),
        'progress' => 100,
    ]);

    $response = $this->actingAs($user)->get('/certificates');

    $response->assertOk();
    $response->assertSee('My Certificates');
    $response->assertSee($course->title);
});
