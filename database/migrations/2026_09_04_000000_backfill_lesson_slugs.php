<?php

use App\Models\Lesson;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Lesson::query()
            ->where(function ($query) {
                $query->whereNull('slug')->orWhere('slug', '');
            })
            ->orderBy('id')
            ->each(function (Lesson $lesson): void {
                $base = Str::slug($lesson->title) ?: 'lesson';
                $slug = $base . '-' . $lesson->id;
                $lesson->forceFill(['slug' => $slug])->saveQuietly();
            });
    }

    public function down(): void
    {
        // Existing slugs are intentionally preserved on rollback.
    }
};
