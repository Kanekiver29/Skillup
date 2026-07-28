<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeDurationThumbnailToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            if (!Schema::hasColumn('modules', 'type')) {
                $table->string('type')->nullable()->after('title');
            }

            if (!Schema::hasColumn('modules', 'duration')) {
                $table->integer('duration')->nullable()->after('type');
            }

            if (!Schema::hasColumn('modules', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('duration');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            // Drop in reverse order to be safe
            if (Schema::hasColumn('modules', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
            if (Schema::hasColumn('modules', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('modules', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
}
