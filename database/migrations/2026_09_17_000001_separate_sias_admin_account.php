<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('email', 'siasadmin@skillup.test')
            ->update([
                'is_admin' => true,
                'role' => 'sias_admin',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('email', 'siasadmin@skillup.test')
            ->update([
                'is_admin' => true,
                'role' => 'admin',
                'updated_at' => now(),
            ]);
    }
};