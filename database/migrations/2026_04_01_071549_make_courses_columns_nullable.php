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
        Schema::table('courses', function (Blueprint $table) {
            $table->text('short_description')->nullable()->change();
            $table->longText('description')->nullable()->change();
            $table->string('instructor_name')->nullable()->change();
            $table->string('instructor_title')->nullable()->change();
            $table->integer('duration_hours')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->text('short_description')->nullable(false)->change();
            $table->longText('description')->nullable(false)->change();
            $table->string('instructor_name')->nullable(false)->change();
            $table->string('instructor_title')->nullable(false)->change();
            $table->integer('duration_hours')->nullable(false)->change();
        });
    }
};
