<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('user_quiz_attempts', 'xp_awarded')) {
                $table->integer('xp_awarded')->default(0)->after('score_percentage');
            }
        });
    }

    public function down()
    {
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('user_quiz_attempts', 'xp_awarded')) $table->dropColumn('xp_awarded');
        });
    }
};
