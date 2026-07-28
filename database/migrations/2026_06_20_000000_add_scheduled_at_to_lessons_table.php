<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'scheduled_at')) {
                $table->timestamp('scheduled_at')->nullable()->after('duration_minutes');
                $table->index('scheduled_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'scheduled_at')) {
                $table->dropIndex(['scheduled_at']);
                $table->dropColumn('scheduled_at');
            }
        });
    }
};
