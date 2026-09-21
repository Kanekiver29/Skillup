<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Subject;
use App\Models\Course;

class TeacherSubjectsTest extends TestCase
{
    /**
     * Test that admin users can access teacher subjects index without 403.
     */
    public function test_admin_can_access_teacher_subjects_index()
    {
        $admin = User::where('is_admin', 1)->first();
        if (!$admin) {
            $admin = User::factory()->create(['is_admin' => 1]);
        }

        $response = $this->actingAs($admin)->get('/teacher/subjects');
        
        $this->assertEquals(200, $response->status(), 'Admin should be able to access /teacher/subjects without 403');
    }

    /**
     * Test that teacher users can access teacher subjects index.
     */
    public function test_teacher_can_access_teacher_subjects_index()
    {
        $teacher = User::where('role', 'teacher')->first();
        if (!$teacher) {
            $teacher = User::factory()->create(['role' => 'teacher']);
        }

        $response = $this->actingAs($teacher)->get('/teacher/subjects');
        
        $this->assertEquals(200, $response->status(), 'Teacher should be able to access /teacher/subjects');
    }

    /**
     * Test that guest users get redirected to login.
     */
    public function test_guest_redirect_to_login()
    {
        $response = $this->get('/teacher/subjects');
        
        $this->assertTrue($response->status() === 302 || $response->status() === 301, 'Guest should be redirected');
    }

    /**
     * Test that subject create form is accessible.
     */
    public function test_admin_can_access_create_subject_form()
    {
        $admin = User::where('is_admin', 1)->first();
        if (!$admin) {
            $admin = User::factory()->create(['is_admin' => 1]);
        }

        $response = $this->actingAs($admin)->get('/teacher/subjects/create');
        
        $this->assertEquals(200, $response->status(), 'Admin should access subject create form');
    }
}
