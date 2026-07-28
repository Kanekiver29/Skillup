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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->datetime('last_message_at')->nullable();
            $table->integer('user_unread_count')->default(0);
            $table->integer('staff_unread_count')->default(0);
            $table->timestamps();

            // Indexes for common queries
            $table->index('user_id');
            $table->index('staff_id');
            $table->index('last_message_at');
            // Prevent duplicate conversations between same user-staff pair
            $table->unique(['user_id', 'staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
