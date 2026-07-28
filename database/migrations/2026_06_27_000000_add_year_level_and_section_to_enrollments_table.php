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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->unsignedTinyInteger('year_level')->nullable()->after('course_id')->comment('Student year level or grade');
            $table->string('section', 100)->nullable()->after('year_level')->comment('Student section or group identifier');
            $table->timestamp('enrolled_at')->nullable()->after('section')->comment('Date/time the student enrolled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['year_level', 'section']);
        });
    }
};
