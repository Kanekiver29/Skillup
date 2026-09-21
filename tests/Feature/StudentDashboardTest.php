<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_shows_summary_cards()
    {
        // Seed minimal demo data
        $user = User::factory()->create(['email' => 'test.student@example.com', 'role' => 'student']);
        $course = Course::factory()->create();
        Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id, 'status' => 'active']);

        if (\Schema::hasTable('announcements')) {
            DB::table('announcements')->insert(['title' => 'Test announcement', 'message' => 'Hello', 'created_at' => now(), 'updated_at' => now()]);
        }

        if (\Schema::hasTable('attendances')) {
            DB::table('attendances')->insert(['user_id' => $user->id, 'attended_at' => now(), 'present' => 1, 'created_at' => now(), 'updated_at' => now()]);
        }

        $response = $this->actingAs($user)->get(route('sias.student.dashboard'));
        $response->assertStatus(200);
        $response->assertSeeText('Enrolled Subjects');
        $response->assertSeeText('Attendance Today');
        $response->assertSeeText('General Weighted Average');
        $response->assertSeeText('Recent Announcements');
    }

    public function test_authenticated_header_has_student_profile_menu()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Student Profile');
        $response->assertSee('id="header-user-wrap"', false);
    }

    public function test_student_notifications_page_loads_without_error()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get(route('sias.student.notifications'));

        $response->assertStatus(200);
        $response->assertSeeText('No notifications');
    }

    public function test_student_sees_selected_enrolled_course_and_subject_in_user_course_page()
    {
        $user = User::factory()->create(['role' => 'student']);

        $firstCourse = Course::factory()->create(['title' => 'First Course', 'slug' => 'first-course', 'is_published' => true]);
        $secondCourse = Course::factory()->create(['title' => 'Second Course', 'slug' => 'second-course', 'is_published' => true]);

        $firstSubject = Subject::create([
            'title' => 'First Subject',
            'course_id' => $firstCourse->id,
            'teacher_id' => $user->id,
            'is_active' => true,
            'units' => 3,
        ]);

        $secondSubject = Subject::create([
            'title' => 'Second Subject',
            'course_id' => $secondCourse->id,
            'teacher_id' => $user->id,
            'is_active' => true,
            'units' => 4,
        ]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $firstCourse->id,
            'subject_id' => $firstSubject->id,
            'status' => 'approved',
            'progress' => 10,
            'completed' => false,
            'enrolled_at' => now(),
        ]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $secondCourse->id,
            'subject_id' => $secondSubject->id,
            'status' => 'approved',
            'progress' => 25,
            'completed' => false,
            'enrolled_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('courses.index', ['course_id' => $secondCourse->id]));

        $response->assertStatus(200);
        $response->assertSeeText('Second Course');
        $response->assertSeeText('Second Subject');
        $response->assertDontSeeText('First Course');
    }
}
