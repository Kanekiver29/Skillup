<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'code')) {
                $table->string('code', 50)->nullable()->after('title');
            }
            if (!Schema::hasColumn('courses', 'department')) {
                $table->string('department', 255)->nullable()->after('code');
            }
            if (!Schema::hasColumn('courses', 'duration')) {
                $table->integer('duration')->nullable()->default(4)->after('duration_hours');
            }
            if (!Schema::hasColumn('courses', 'curriculum')) {
                $table->string('curriculum', 255)->nullable()->after('duration');
            }
            if (!Schema::hasColumn('courses', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_published');
            }
        });

        // Add semester & subject_id column & widen year_level and semester in enrollments
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'semester')) {
                $table->string('semester', 50)->nullable()->after('section');
            }
            if (!Schema::hasColumn('enrollments', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('course_id');
            }
        });
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE enrollments MODIFY year_level VARCHAR(50) NULL');
            DB::statement('ALTER TABLE enrollments MODIFY semester VARCHAR(50) NULL');
        }
        try {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->index('user_id', 'enrollments_user_id_index');
                $table->dropUnique('enrollments_user_id_course_id_unique');
            });
        } catch (\Exception $e) {}
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $cols = ['code', 'department', 'duration', 'curriculum', 'is_active'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('courses', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('enrollments', 'semester')) {
                $table->dropColumn('semester');
            }
        });
    }
};
