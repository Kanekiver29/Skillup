<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_quiz_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_quiz_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_question_answer_id')->nullable()->constrained()->onDelete('set null');
            $table->text('answer_text')->nullable(); // For short answer questions
            $table->boolean('is_correct')->default(false);
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            $table->index('user_quiz_attempt_id');
            $table->index('quiz_question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_quiz_responses');
    }
};
