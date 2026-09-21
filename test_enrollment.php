<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(1);
if (!$user) { echo "No user\n"; exit; }
$course = App\Models\Course::first();
if (!$course) { echo "No course\n"; exit; }
$enrollment = $user->enrollments()->create(['course_id' => $course->id, 'status' => 'active']);
echo "Created enrollment: {$enrollment->id}\n";
echo "Course: {$course->title}\n";
$instructor = $course->instructor;
echo "Instructor class: " . ($instructor ? get_class($instructor) : 'null') . "\n";
if ($instructor) {
    echo "Instructor name: " . $instructor->name . "\n";
    echo "Instructor staff_type: " . ($instructor->staff_type ?? 'null') . "\n";
}
