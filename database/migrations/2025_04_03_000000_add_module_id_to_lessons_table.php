<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Add module_id foreign key to lessons table
            $table->foreignId('module_id')->nullable()->constrained()->onDelete('cascade')->after('course_id');
            $table->index('module_id');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeignIdFor('Module::class');
            $table->dropIndex(['module_id']);
        });
    }
};
