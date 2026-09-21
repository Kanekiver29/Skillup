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
            $table->foreignId('major_id')
                ->nullable()
                ->after('assigned_course_id')
                ->constrained('majors')
                ->onDelete('set null')
                ->comment('Student major/program');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('major_id')
                ->nullable()
                ->after('department')
                ->constrained('majors')
                ->onDelete('set null')
                ->comment('Major this course belongs to');
            
            $table->boolean('is_primary')
                ->default(false)
                ->after('major_id')
                ->comment('Whether this is the primary/designated course for the major');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['major_id']);
            $table->dropColumn(['major_id', 'is_primary']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['major_id']);
            $table->dropColumn(['major_id']);
        });
    }
};
