<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trivia_quick_play_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('game_type', 32);
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('max_score')->default(0);
            $table->unsignedTinyInteger('score_percentage')->default(0);
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->index(['completed_at', 'score_percentage']);
            $table->index(['user_id', 'game_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trivia_quick_play_scores');
    }
};
