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
        Schema::table('users', function (Blueprint $table) {
            // Profile Information - User Details
            $table->text('bio')->nullable()->after('is_admin');
            $table->string('location')->nullable()->after('bio');
            $table->string('portfolio_url')->nullable()->after('location');
            
            // Skills & Profile Settings
            $table->json('skills')->nullable()->after('portfolio_url');
            $table->boolean('profile_public')->default(true)->after('skills');
            
            // Learning Tracking
            $table->integer('hours_spent')->default(0)->after('profile_public')->comment('Total hours spent learning');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'location',
                'portfolio_url',
                'skills',
                'profile_public',
                'hours_spent',
            ]);
        });
    }
};