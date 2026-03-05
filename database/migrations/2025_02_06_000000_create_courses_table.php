<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            // === COURSE BASIC INFO ===
            $table->id();
            $table->string('title')->comment('Course title/name');
            $table->string('slug')->unique()->comment('URL-friendly identifier');
            $table->text('short_description')->comment('Brief course summary (for listings)');
            $table->longText('description')->comment('Full course description');
            
            // === COURSE CLASSIFICATION ===
            $table->string('category')->comment('Course category (e.g., Web Development, Design)');
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            
            // === INSTRUCTOR INFO ===
            $table->string('instructor_name');
            $table->string('instructor_title')->comment('Job title or expertise of instructor');
            
            // === COURSE MEDIA & RESOURCES ===
            $table->string('image_url')->nullable()->comment('Course cover image');
            $table->integer('duration_hours')->comment('Total course duration in hours');
            
            // === COURSE METRICS ===
            $table->float('rating')->default(0)->comment('Average rating (0-5)');
            $table->integer('students_count')->default(0)->comment('Number of enrolled students');
            
            // === COURSE STATUS ===
            $table->boolean('is_published')->default(true)->comment('true = Published, false = Draft');
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            // === LESSON BASIC INFO ===
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title')->comment('Lesson title');
            $table->text('description')->comment('Brief lesson overview');
            $table->longText('content')->comment('Full lesson content/text');
            
            // === LESSON MEDIA ===
            $table->string('video_url')->nullable()->comment('Video lesson link (if applicable)');
            $table->integer('duration_minutes')->comment('Time to complete lesson in minutes');
            
            // === LESSON ORGANIZATION ===
            $table->integer('order')->default(0)->comment('Order within course (1, 2, 3, etc)');
            $table->boolean('is_published')->default(true);
            
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            // === USER COURSE ENROLLMENT ===
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('User enrolled in course');
            $table->foreignId('course_id')->constrained()->onDelete('cascade')->comment('Course being taken');
            
            // === PROGRESS TRACKING ===
            $table->integer('progress')->default(0)->comment('Completion percentage (0-100)');
            $table->boolean('completed')->default(false)->comment('true = Course completed');
            $table->timestamp('completed_at')->nullable()->comment('Date course was completed');
            $table->integer('hours_spent')->default(0)->comment('Hours spent on this course');
            
            $table->timestamps();
            
            // Ensure each user enrolls in a course only once
            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('lesson_enrollments', function (Blueprint $table) {
            // === INDIVIDUAL LESSON COMPLETION ===
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            
            // === LESSON PROGRESS ===
            $table->boolean('completed')->default(false)->comment('true = Lesson completed by user');
            $table->timestamp('completed_at')->nullable()->comment('When the lesson was completed');
            
            $table->timestamps();
            
            // Ensure each enrollment completes lesson only once (no duplicates)
            $table->unique(['enrollment_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_enrollments');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('courses');
    }
};
