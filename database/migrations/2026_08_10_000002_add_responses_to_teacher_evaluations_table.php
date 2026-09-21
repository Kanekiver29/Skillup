<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teacher_evaluations', function (Blueprint $table) {
            $table->json('responses')->nullable()->after('anonymous');
        });
    }

    public function down()
    {
        Schema::table('teacher_evaluations', function (Blueprint $table) {
            $table->dropColumn('responses');
        });
    }
};
