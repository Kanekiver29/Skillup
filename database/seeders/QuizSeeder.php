<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;
use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::all();

        if ($modules->isEmpty()) {
            $this->command->warn('No modules found. Please seed modules first.');
            return;
        }

        foreach ($modules as $module) {
            // Create 2-3 quizzes per module
            $numberOfQuizzes = random_int(2, 3);

            for ($q = 1; $q <= $numberOfQuizzes; $q++) {
                $quiz = Quiz::create([
                    'module_id' => $module->id,
                    'title' => $module->title . ": Quiz " . $q,
                    'slug' => Str::slug($module->slug . "-quiz-" . $q),
                    'description' => "Test your knowledge on " . strtolower($module->title) . ". This quiz contains multiple choice and true/false questions.",
                    'passing_score' => 70,
                    'time_limit_minutes' => random_int(15, 45),
                    'attempt_limit' => 3,
                    'randomize_questions' => random_int(0, 1) === 1,
                    'show_correct_answers' => true,
                    'order' => $q,
                    'is_published' => true,
                ]);

                // Create 5-10 questions per quiz
                $numberOfQuestions = random_int(5, 10);

                for ($i = 1; $i <= $numberOfQuestions; $i++) {
                    $question = QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'type' => $this->getRandomQuestionType(),
                        'question_text' => $this->generateQuestion($module->title, $i),
                        'explanation' => "This is the explanation for question " . $i . ". It provides additional context and learning information about the topic.",
                        'points' => random_int(1, 3),
                        'order' => $i,
                    ]);

                    // Create answers for the question
                    if ($question->type === 'true_false') {
                        QuizQuestionAnswer::create([
                            'quiz_question_id' => $question->id,
                            'answer_text' => 'True',
                            'is_correct' => random_int(0, 1) === 1,
                            'order' => 1,
                        ]);

                        QuizQuestionAnswer::create([
                            'quiz_question_id' => $question->id,
                            'answer_text' => 'False',
                            'is_correct' => random_int(0, 1) === 1,
                            'order' => 2,
                        ]);
                    } else {
                        // Multiple choice - 4 options
                        $correctAnswerPosition = random_int(0, 3);

                        for ($j = 0; $j < 4; $j++) {
                            QuizQuestionAnswer::create([
                                'quiz_question_id' => $question->id,
                                'answer_text' => $this->generateAnswer($j),
                                'is_correct' => $j === $correctAnswerPosition,
                                'order' => $j + 1,
                            ]);
                        }
                    }
                }
            }
        }

        $this->command->info('Quizzes seeded successfully!');
    }

    private function getRandomQuestionType(): string
    {
        $types = ['multiple_choice', 'true_false'];
        return $types[array_rand($types)];
    }

    private function generateQuestion(string $module, int $number): string
    {
        $questions = [
            "Which of the following is a fundamental concept in " . $module . "?",
            "What is the primary purpose of " . strtolower($module) . "?",
            "How would you apply " . strtolower($module) . " in a real-world scenario?",
            "Which technique is most important when learning " . strtolower($module) . "?",
            "What is the relationship between the concepts covered in this module?",
            "Identify which statement best describes " . strtolower($module) . ".",
            "Which best practice should you follow when working with " . strtolower($module) . "?",
            "How does " . $module . " relate to the overall course objectives?",
        ];

        return $questions[($number - 1) % count($questions)];
    }

    private function generateAnswer(int $index): string
    {
        $answers = [
            "Option A - Implementation approach",
            "Option B - Best practice method",
            "Option C - Common pattern",
            "Option D - Advanced technique",
        ];

        return $answers[$index] ?? "Option " . chr(65 + $index);
    }
}
