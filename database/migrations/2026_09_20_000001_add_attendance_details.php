<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            $table->time('time_in')->nullable()->after('status');
            $table->time('time_out')->nullable()->after('time_in');
        });

        DB::statement("ALTER TABLE attendance_records MODIFY status ENUM('present', 'absent', 'late', 'excused') NOT NULL DEFAULT 'present'");
    }

    public function down(): void
    {
        DB::table('attendance_records')->where('status', 'excused')->update(['status' => 'absent']);
        DB::statement("ALTER TABLE attendance_records MODIFY status ENUM('present', 'absent', 'late') NOT NULL DEFAULT 'present'");

        Schema::table('attendance_records', function (Blueprint $table) {
            $table->dropColumn(['time_in', 'time_out']);
        });
    }
};
