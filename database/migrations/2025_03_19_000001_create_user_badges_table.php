<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->string('badgeable_type'); // App\Models\Module, App\Models\Quiz, App\Models\Course
            $table->unsignedBigInteger('badgeable_id');
            $table->timestamp('earned_at');
            $table->timestamps();

            $table->unique(['user_id', 'badge_id', 'badgeable_type', 'badgeable_id'], 'user_badge_unique');
            $table->index(['user_id']);
            $table->index(['badgeable_type', 'badgeable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_badges');
    }
};
