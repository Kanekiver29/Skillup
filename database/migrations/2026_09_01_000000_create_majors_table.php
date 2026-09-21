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
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Major/program name (e.g., Information Technology)');
            $table->string('code')->unique()->comment('Major code (e.g., IT)');
            $table->text('description')->nullable()->comment('Description of the major');
            $table->string('department')->nullable()->comment('Department this major belongs to');
            $table->string('icon')->nullable()->comment('Icon/emoji for the major');
            $table->string('color')->nullable()->comment('Brand color for the major (hex)');
            $table->boolean('is_active')->default(true)->comment('Whether this major is active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
