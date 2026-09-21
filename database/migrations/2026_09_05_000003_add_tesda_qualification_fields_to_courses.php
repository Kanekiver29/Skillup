<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('sector_industry')->nullable()->after('department');
            $table->text('qualification_description')->nullable()->after('description');
            $table->string('qualification_level')->nullable()->after('category');
            $table->string('training_regulations_version')->nullable()->after('curriculum');
            $table->string('program_registration_no')->nullable()->after('training_regulations_version');
            $table->string('registration_status')->default('Registered')->after('program_registration_no');
            $table->date('registration_date')->nullable()->after('registration_status');
            $table->decimal('nominal_training_duration', 8, 2)->nullable()->after('duration');
            $table->string('delivery_mode')->nullable()->after('nominal_training_duration');
            $table->unsignedInteger('maximum_batch_capacity')->nullable()->after('delivery_mode');
            $table->json('competencies')->nullable()->after('maximum_batch_capacity');
            $table->string('program_status')->default('Active')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'sector_industry', 'qualification_description', 'qualification_level',
                'training_regulations_version', 'program_registration_no',
                'registration_status', 'registration_date', 'nominal_training_duration',
                'delivery_mode', 'maximum_batch_capacity', 'competencies', 'program_status',
            ]);
        });
    }
};
