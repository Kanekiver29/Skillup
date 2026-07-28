<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('allows staff teachers to log in as teachers', function () {
    $teacher = User::factory()->create([
        'name' => 'Teacher User',
        'email' => 'teacher-access@example.com',
        'role' => 'staff',
        'staff_type' => 'teacher',
        'is_admin' => false,
        'email_verified_at' => null,
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => $teacher->email,
        'password' => 'password123',
        'login_as' => 'teacher',
    ]);

    $response->assertRedirect(route('teacher.dashboard'));
    $this->assertAuthenticatedAs($teacher);
});

it('allows accounts flagged as teachers by staff_type to log in as teachers even when role is student', function () {
    $teacher = User::factory()->create([
        'name' => 'Teacher By Staff Type',
        'email' => 'teacher-staff-type@example.com',
        'role' => 'student',
        'staff_type' => 'teacher',
        'is_admin' => false,
        'email_verified_at' => null,
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => $teacher->email,
        'password' => 'password123',
        'login_as' => 'teacher',
    ]);

    $response->assertRedirect(route('teacher.dashboard'));
    $this->assertAuthenticatedAs($teacher);
});
