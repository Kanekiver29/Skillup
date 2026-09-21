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
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('subject_code')->nullable()->after('id');
            $table->text('description')->nullable()->after('title');
            $table->integer('units')->nullable()->after('description');
            $table->integer('hours')->nullable()->after('units');
            $table->boolean('is_active')->default(true)->after('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['subject_code', 'description', 'units', 'hours', 'is_active']);
        });
    }
};
