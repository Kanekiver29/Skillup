<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->boolean('is_trivia')->default(false)->after('show_correct_answers');
            $table->foreignId('major_id')->nullable()->after('is_trivia')->constrained()->nullOnDelete();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->nullable()->after('is_trivia');
            $table->unsignedInteger('question_count')->nullable()->after('difficulty');
            $table->unsignedInteger('question_time_limit_seconds')->nullable()->after('question_count');
            $table->dateTime('scheduled_at')->nullable()->after('question_time_limit_seconds');
            $table->index(['is_trivia', 'is_published', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropIndex(['quizzes_is_trivia_is_published_scheduled_at_index']);
            $table->dropColumn([
                'is_trivia',
                'major_id',
                'difficulty',
                'question_count',
                'question_time_limit_seconds',
                'scheduled_at',
            ]);
        });
    }
};