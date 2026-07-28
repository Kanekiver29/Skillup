<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only run if column exists and there are legacy instructor_name values
        if (!Schema::hasColumn('courses', 'instructor_id')) {
            return;
        }

        // Set instructor_id by matching users.name to courses.instructor_name
        DB::table('courses')
            ->whereNotNull('instructor_name')
            ->update(['instructor_id' => null]);

        $users = DB::table('users')->select('id', 'name')->get();

        foreach ($users as $user) {
            DB::table('courses')
                ->where('instructor_name', $user->name)
                ->update(['instructor_id' => $user->id]);
        }
    }

    public function down(): void
    {
        // Rollback: clear instructor_id
        if (!Schema::hasColumn('courses', 'instructor_id')) {
            return;
        }

        DB::table('courses')->update(['instructor_id' => null]);
    }
};
