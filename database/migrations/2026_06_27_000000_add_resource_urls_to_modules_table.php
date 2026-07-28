<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            if (!Schema::hasColumn('modules', 'word_url')) {
                $table->string('word_url')->nullable()->after('thumbnail');
            }
            if (!Schema::hasColumn('modules', 'video_url')) {
                $table->string('video_url')->nullable()->after('word_url');
            }
            if (!Schema::hasColumn('modules', 'image_url')) {
                $table->string('image_url')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('modules', 'ppt_url')) {
                $table->string('ppt_url')->nullable()->after('image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            if (Schema::hasColumn('modules', 'ppt_url')) {
                $table->dropColumn('ppt_url');
            }
            if (Schema::hasColumn('modules', 'image_url')) {
                $table->dropColumn('image_url');
            }
            if (Schema::hasColumn('modules', 'video_url')) {
                $table->dropColumn('video_url');
            }
            if (Schema::hasColumn('modules', 'word_url')) {
                $table->dropColumn('word_url');
            }
        });
    }
};
