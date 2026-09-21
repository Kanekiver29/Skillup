<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('quizzes', 'major_id')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->foreignId('major_id')->nullable()->after('is_trivia')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('quizzes', 'major_id')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropForeign(['major_id']);
                $table->dropColumn('major_id');
            });
        }
    }
};
