<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grade_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('assessment_type', ['activity', 'assignment', 'exam', 'module'])->default('activity');
            $table->string('title');
            $table->decimal('score', 8, 2);
            $table->decimal('max_score', 8, 2)->default(100);
            $table->text('remarks')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['student_id', 'course_id', 'assessment_type']);
        });
    }

    public function down(): void { Schema::dropIfExists('grade_records'); }
};