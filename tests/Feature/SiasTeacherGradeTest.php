<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\GradeRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a teacher to view and update a student grade for their course', function () {
    $teacher = User::factory()->create([
        'name' => 'Teacher Grade User',
        'role' => 'teacher',
        'email' => 'teacher-grade@example.com',
    ]);

    $student = User::factory()->create([
        'name' => 'Student Grade User',
        'role' => 'student',
        'email' => 'student-grade@example.com',
    ]);

    $course = Course::factory()->create([
        'title' => 'Electrical Installation',
        'instructor_id' => $teacher->id,
        'instructor_name' => $teacher->name,
    ]);

    $enrollment = Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'Active',
    ]);

    $response = $this->actingAs($teacher)->get(route('sias.teacher.grades.index'));

    $response->assertOk();
    $response->assertSee('Electrical Installation');
    $response->assertSee('Student Grade User');

    $updateResponse = $this->actingAs($teacher)->patch(route('sias.teacher.grades.update', $enrollment), [
        'final_grade' => '88',
    ]);

    $updateResponse->assertRedirect(route('sias.teacher.grades.index'));
    $this->assertSame(88.0, round((float) $enrollment->fresh()->final_grade, 1));
});

it('allows a teacher to add and edit student grades from the student overview', function () {
    $teacher = User::factory()->create([
        'name' => 'Trainer Grade User',
        'role' => 'teacher',
        'email' => 'trainer-grade@example.com',
    ]);

    $student = User::factory()->create([
        'name' => 'Learner Grade User',
        'role' => 'student',
        'email' => 'learner-grade@example.com',
    ]);

    $course = Course::factory()->create([
        'title' => 'Electrical Wiring',
        'instructor_id' => $teacher->id,
        'instructor_name' => $teacher->name,
    ]);

    $enrollment = Enrollment::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'Active',
    ]);

    $viewResponse = $this->actingAs($teacher)->get(route('teacher.students.show', $enrollment->id));
    $viewResponse->assertOk();
    $viewResponse->assertSee('Add student grade');

    $storeResponse = $this->actingAs($teacher)->post(route('teacher.grades.store'), [
        'student_id' => $student->id,
        'course_id' => $course->id,
        'module_id' => null,
        'assessment_type' => 'exam',
        'title' => 'Midterm Exam',
        'score' => 88,
        'max_score' => 100,
        'remarks' => 'Strong effort',
    ]);

    $storeResponse->assertRedirect();
    $this->assertDatabaseHas('grade_records', [
        'student_id' => $student->id,
        'course_id' => $course->id,
        'title' => 'Midterm Exam',
    ]);
    $this->assertSame(88.0, round((float) $enrollment->fresh()->final_grade, 1));

    $gradeRecord = GradeRecord::query()
        ->where('student_id', $student->id)
        ->where('course_id', $course->id)
        ->where('title', 'Midterm Exam')
        ->firstOrFail();

    $updateResponse = $this->actingAs($teacher)->patch(route('teacher.grades.update', $gradeRecord), [
        'score' => 92,
        'max_score' => 100,
        'remarks' => 'Excellent improvement',
    ]);

    $updateResponse->assertRedirect();
    $this->assertSame(92.0, round((float) $enrollment->fresh()->final_grade, 1));
    $this->assertDatabaseHas('grade_records', ['id' => $gradeRecord->id, 'remarks' => 'Excellent improvement']);
});
