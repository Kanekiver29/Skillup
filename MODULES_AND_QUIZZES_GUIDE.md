# Module & Quiz System - Complete Guide

## Overview

The SkillUp learning portal now includes a comprehensive module and quiz system that allows:

- **Organize courses into modules** - Group lessons and assessments by topic
- **Create interactive quizzes** - Support for multiple choice, true/false, and short answer questions
- **Track real-time progress** - Real-time statistics and performance tracking
- **Attempt management** - Control how many times students can attempt quizzes
- **Immediate feedback** - Show correct answers and explanations after completion

## Database Structure

### Tables Created

1. **modules** - Course modules/sections
2. **quizzes** - Quiz instances within modules
3. **quiz_questions** - Individual quiz questions
4. **quiz_question_answers** - Answer options for questions
5. **user_quiz_attempts** - Track student quiz attempts
6. **user_quiz_responses** - Individual responses to questions

## Models Created

All models are located in `app/Models/`:

- `Module.php` - Module management
- `Quiz.php` - Quiz management with helper methods
- `QuizQuestion.php` - Question management
- `QuizQuestionAnswer.php` - Answer options
- `UserQuizAttempt.php` - Attempt tracking with time calculations
- `UserQuizResponse.php` - Individual responses

## Controllers

### ModuleController
**Location:** `app/Http/Controllers/ModuleController.php`

Shows module details with all associated quizzes:
```php
Route::get('/courses/{courseSlug}/modules/{moduleSlug}', [ModuleController::class, 'show'])->name('modules.show');
```

### QuizController
**Location:** `app/Http/Controllers/QuizController.php`

Handles quiz operations:

1. **show** - Display quiz details and attempt history
2. **start** - Initiate a new quiz attempt
3. **submitAttempt** - Process submitted answers and calculate score
4. **results** - Display detailed results and feedback

Routes:
```php
Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}', [QuizController::class, 'show'])->name('quizzes.show');
Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/start', [QuizController::class, 'start'])->name('quizzes.start');
Route::post('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/submit', [QuizController::class, 'submitAttempt'])->name('quizzes.submit');
Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/results/{attemptId}', [QuizController::class, 'results'])->name('quizzes.results');
```

### StatsController (API)
**Location:** `app/Http/Controllers/Api/StatsController.php`

Provides real-time statistics endpoints:

1. **courseStats** - Get overall course progress and module stats
2. **quizStats** - Get quiz-specific statistics and attempt history
3. **userDashboardStats** - Get user's overall learning statistics
4. **adminCourseStats** - Get administrative course analytics

Routes:
```php
Route::get('/api/stats/course/{courseSlug}', [StatsController::class, 'courseStats']);
Route::get('/api/stats/quiz/{courseSlug}/{moduleSlug}/{quizSlug}', [StatsController::class, 'quizStats']);
Route::get('/api/stats/dashboard', [StatsController::class, 'userDashboardStats']);
Route::get('/api/stats/admin/course/{courseSlug}', [StatsController::class, 'adminCourseStats']);
```

## Views

### Module Views
- **show.blade.php** - Display module with all quizzes

### Quiz Views
- **show.blade.php** - Quiz details page with attempt history
- **attempt.blade.php** - Quiz taking interface with timer
- **results.blade.php** - Results and detailed feedback

## Key Features

### 1. Real-Time Progress Tracking
```php
// Get module progress
$progress = $module->getProgress($userId); // Returns 0-100%

// Get quiz best score
$bestScore = $quiz->getUserBestScore($userId);

// Check if user passed
$hasPassed = $quiz->hasUserPassed($userId);
```

### 2. Attempt Management
```php
// Check if user can retry
if ($quiz->canUserRetry($userId)) {
    // Allow retry
}

// Get attempt count
$attempts = $quiz->getUserAttemptCount($userId);
```

### 3. Auto-Calculated Scoring
- Points are tracked per question
- Percentage is automatically calculated
- Pass/Fail status based on passing score
- Time tracking for each attempt

### 4. Quiz Features
- **Randomize Questions** - Shuffle question order per attempt
- **Time Limits** - Optional timed quizzes
- **Attempt Limits** - Control max attempts (default: 3)
- **Show Answers** - Reveal correct answers after completion
- **Question Explanations** - Provide learning feedback

### 5. Question Types
- **Multiple Choice** - 4 answer options
- **True/False** - Boolean questions
- **Short Answer** - Text response (pending review)

## Usage Examples

### Display Module with Quizzes
```blade
<!-- In views/courses/modules/show.blade.php -->
@foreach($quizzes as $quiz)
    <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}">
        {{ $quiz->title }}
    </a>
@endforeach
```

### Get Course Statistics
```javascript
// Fetch real-time stats
fetch('/api/stats/course/{{ $course->slug }}')
    .then(r => r.json())
    .then(data => {
        console.log(data.course_progress_percentage);
        console.log(data.modules);
    });
```

### Display Quiz Progress
```blade
{{ $quiz->getUserBestScore(auth()->id()) }}% - Best Score
{{ $quiz->getUserAttemptCount(auth()->id()) }}/{{ $quiz->attempt_limit }} - Attempts
```

## Seeding Sample Data

Sample modules and quizzes are automatically created when running seeders:

```bash
php artisan migrate:fresh --seed
```

This creates:
- 3-5 modules per course
- 2-3 quizzes per module
- 5-10 questions per quiz
- 4 answer options per multiple choice question

## API Response Examples

### Course Stats
```json
{
    "course_id": 1,
    "course_title": "Web Development",
    "total_modules": 4,
    "completed_modules": 1,
    "course_progress_percentage": 25,
    "modules": [
        {
            "module_id": 1,
            "module_title": "Module 1: Fundamentals",
            "progress_percentage": 100,
            "total_quizzes": 2,
            "completed_quizzes": 2,
            "quizzes": [
                {
                    "quiz_id": 1,
                    "quiz_title": "Module 1: Quiz 1",
                    "best_score": 85,
                    "has_passed": true,
                    "attempt_count": 2,
                    "attempt_limit": 3,
                    "can_retry": true,
                    "passing_score": 70
                }
            ]
        }
    ]
}
```

### Quiz Stats
```json
{
    "quiz_id": 1,
    "quiz_title": "Module 1: Quiz 1",
    "best_score": 85,
    "has_passed": true,
    "attempt_count": 2,
    "attempt_limit": 3,
    "can_retry": true,
    "passing_score": 70,
    "attempts": [
        {
            "attempt_id": 1,
            "attempt_number": 1,
            "score_percentage": 75,
            "correct_answers": 7,
            "total_questions": 9,
            "passed": true,
            "time_spent": "12m 45s",
            "completed_at": "Feb 22, 2026 08:30"
        }
    ]
}
```

## Customization

### Modify Passing Score
```php
// In quiz creation/update
$quiz->passing_score = 80; // Require 80% to pass
$quiz->save();
```

### Adjust Time Limits
```php
// No time limit
$quiz->time_limit_minutes = null;

// 30 minute limit
$quiz->time_limit_minutes = 30;
```

### Change Attempt Limits
```php
// Allow unlimited attempts
$quiz->attempt_limit = 999;

// Allow single attempt
$quiz->attempt_limit = 1;
```

## Future Enhancements

1. **AI-Powered Grading** - Auto-grade short answer questions
2. **Adaptive Quizzes** - Difficulty adjustment based on performance
3. **Quiz Pools** - Randomly select from question banks
4. **Discussion Forums** - Per-quiz discussion threads
5. **Leaderboards** - Class-wide competition and rankings
6. **Certificates** - Award completion certificates
7. **Email Notifications** - Send quiz reminders and results

## Troubleshooting

### Quiz not showing
- Ensure quiz `is_published = true`
- Verify user is enrolled in the course
- Check that module is published

### Answers not saving
- Ensure user is authenticated
- Verify quiz has not timed out
- Check browser console for JavaScript errors

### Wrong scores
- Verify correct answers are marked in `quiz_question_answers`
- Check question points are set correctly
- Confirm passing_score configuration

## Support

For issues or questions about the module and quiz system, refer to the database schema in [DATABASE_IMPROVEMENTS.md](DATABASE_IMPROVEMENTS.md) or contact the development team.
