<?php

use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('quiz grading uses real answers instead of placeholder scores', function () {
    $course = Course::factory()->create(['is_published' => true]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Sample Module',
        'slug' => 'sample-module',
        'description' => 'Sample module description',
        'is_published' => true,
        'order' => 1,
    ]);

    $quiz = Quiz::create([
        'module_id' => $module->id,
        'title' => 'Sample Quiz',
        'slug' => 'sample-quiz',
        'description' => 'A sample assessment',
        'passing_score' => 70,
        'attempt_limit' => 3,
        'is_published' => true,
        'order' => 1,
    ]);

    $questionOne = QuizQuestion::create([
        'quiz_id' => $quiz->id,
        'type' => 'multiple_choice',
        'question_text' => 'Which planet is known as the Red Planet?',
        'points' => 1,
        'order' => 1,
    ]);
    QuizQuestionAnswer::create(['quiz_question_id' => $questionOne->id, 'answer_text' => 'Mars', 'is_correct' => true, 'order' => 1]);
    QuizQuestionAnswer::create(['quiz_question_id' => $questionOne->id, 'answer_text' => 'Venus', 'is_correct' => false, 'order' => 2]);

    $questionTwo = QuizQuestion::create([
        'quiz_id' => $quiz->id,
        'type' => 'multiple_choice',
        'question_text' => 'Which language is used to style a webpage?',
        'points' => 1,
        'order' => 2,
    ]);
    QuizQuestionAnswer::create(['quiz_question_id' => $questionTwo->id, 'answer_text' => 'CSS', 'is_correct' => true, 'order' => 1]);
    QuizQuestionAnswer::create(['quiz_question_id' => $questionTwo->id, 'answer_text' => 'PHP', 'is_correct' => false, 'order' => 2]);

    $response = $this->post(route('quiz.submit', $quiz->id), [
        'answers' => [
            $questionOne->id => $questionOne->answers()->where('is_correct', true)->first()->id,
            $questionTwo->id => $questionTwo->answers()->where('is_correct', false)->first()->id,
        ],
    ]);

    $response->assertStatus(200);
    $response->assertSee('50%');
    $response->assertSee('1 of 2 correct');
});
