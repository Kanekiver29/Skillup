<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'lms_local_id')) {
                $table->string('lms_local_id')->nullable()->index();
            }
        });

        Schema::table('modules', function (Blueprint $table) {
            if (!Schema::hasColumn('modules', 'lms_local_id')) {
                $table->string('lms_local_id')->nullable()->index();
            }
        });

        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'lms_local_id')) {
                $table->string('lms_local_id')->nullable()->index();
            }
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_questions', 'lms_local_id')) {
                $table->string('lms_local_id')->nullable()->index();
            }
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('lms_local_id');
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('lms_local_id');
        });
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('lms_local_id');
        });
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropColumn('lms_local_id');
        });
    }
};
