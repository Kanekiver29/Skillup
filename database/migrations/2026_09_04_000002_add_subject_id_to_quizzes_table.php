<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('quizzes', 'subject_id')) {
            Schema::table('quizzes', function (Blueprint $table): void {
                $table->foreignId('subject_id')->nullable()->after('module_id')->constrained('subjects')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('quizzes', 'subject_id')) {
            Schema::table('quizzes', function (Blueprint $table): void {
                $table->dropForeign(['subject_id']);
                $table->dropColumn('subject_id');
            });
        }
    }
};