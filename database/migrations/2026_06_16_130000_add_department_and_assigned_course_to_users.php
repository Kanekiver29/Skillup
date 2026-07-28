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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'department')) {
                    $table->string('department')->nullable()->after('role');
                }
                if (! Schema::hasColumn('users', 'assigned_course_id')) {
                    $table->unsignedBigInteger('assigned_course_id')->nullable()->after('department')->index();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'assigned_course_id')) {
                    $table->dropColumn('assigned_course_id');
                }
                if (Schema::hasColumn('users', 'department')) {
                    $table->dropColumn('department');
                }
            });
        }
    }
};
