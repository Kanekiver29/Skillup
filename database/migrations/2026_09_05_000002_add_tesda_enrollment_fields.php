<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('qualification_name')->nullable()->after('course_id');
            $table->string('qualification_code')->nullable()->after('qualification_name');
            $table->string('training_program')->nullable()->after('qualification_code');
            $table->string('unit_of_competency')->nullable()->after('training_program');
            $table->string('training_center')->nullable()->after('unit_of_competency');
            $table->string('batch_class')->nullable()->after('training_center');
            $table->string('training_schedule')->nullable()->after('batch_class');
            $table->date('training_start_date')->nullable()->after('training_schedule');
            $table->date('training_end_date')->nullable()->after('training_start_date');
            $table->string('training_mode')->nullable()->after('training_end_date');
            $table->string('training_location')->nullable()->after('training_mode');
            $table->string('scholarship_type')->default('None')->after('training_location');
            $table->string('scholarship_reference_no')->nullable()->after('scholarship_type');
            $table->date('enrollment_date')->nullable()->after('scholarship_reference_no');
            $table->json('supporting_documents')->nullable()->after('enrollment_date');
            $table->string('document_status')->default('Pending')->after('supporting_documents');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn([
                'qualification_name', 'qualification_code', 'training_program',
                'unit_of_competency', 'training_center', 'batch_class',
                'training_schedule', 'training_start_date', 'training_end_date',
                'training_mode', 'training_location', 'scholarship_type',
                'scholarship_reference_no', 'enrollment_date', 'supporting_documents',
                'document_status',
            ]);
        });
    }
};
