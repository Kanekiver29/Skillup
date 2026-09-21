<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Lesson extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saving(function (Lesson $lesson): void {
            if (blank($lesson->slug)) {
                $baseSlug = Str::slug($lesson->title) ?: 'lesson';
                $slug = $baseSlug;
                $counter = 1;

                while (static::where('slug', $slug)->where('id', '!=', $lesson->getKey())->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }

                $lesson->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'course_id',
        'module_id',
        'title',
        'slug',
        'description',
        'content',
        'video_url',
        'image_url',
        'material_url',
        'duration_minutes',
        'order',
        'is_published',
        'scheduled_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'scheduled_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class)->withDefault();
    }

    public function enrollments()
    {
        return $this->hasMany(LessonEnrollment::class);
    }

    /**
     * Check if user has completed this lesson
     */
    public function isCompletedBy($userId)
    {
        return $this->enrollments()
            ->where('completed', true)
            ->whereHas('enrollment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->exists();
    }

    /**
     * Get user's progress on this lesson
     */
    public function getUserProgress($userId)
    {
        $lessonEnrollment = $this->enrollments()
            ->whereHas('enrollment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();

        if (!$lessonEnrollment) {
            return 0;
        }

        return $lessonEnrollment->completed ? 100 : 50;
    }

    public function resourceUrl(): ?string
    {
        // Video lessons have a direct URL.
        if (!empty($this->video_url)) {
            return $this->video_url;
        }

        // No content defined.
        if (empty($this->content)) {
            return null;
        }

        // If this is a presentation (ppt, pptx, or JSON template), use Office online viewer.
        if ($this->isPresentation()) {
            $url = filter_var($this->content, FILTER_VALIDATE_URL) ? $this->content : asset($this->content);
            // Encode the URL for the viewer.
            return 'https://view.officeapps.live.com/op/embed.aspx?src=' . rawurlencode($url);
        }

        // If the content is stored as JSON (e.g., template), we don't have a direct URL.
        if ($this->isJsonContent()) {
            return null;
        }

        // For regular URLs or local assets, return appropriate path.
        return filter_var($this->content, FILTER_VALIDATE_URL)
            ? $this->content
            : asset($this->content);
    }

    public function resourceExtension(): ?string
    {
        if (empty($this->content) || $this->isJsonContent()) {
            return null;
        }

        $url = filter_var($this->content, FILTER_VALIDATE_URL) ? $this->content : $this->content;
        $path = parse_url($url, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return $extension ? strtolower($extension) : null;
    }

    public function isJsonContent(): bool
    {
        if (empty($this->content)) {
            return false;
        }

        return is_array($this->contentArray());
    }

    public function contentArray(): ?array
    {
        $decoded = json_decode($this->content, true);
        return is_array($decoded) ? $decoded : null;
    }

    public function isPresentation(): bool
    {
        if ($this->video_url) {
            return false;
        }

        $extension = $this->resourceExtension();
        if (in_array($extension, ['ppt', 'pptx', 'pdf'])) {
            return true;
        }

        $content = $this->contentArray();
        return is_array($content) && isset($content['template']);
    }

    public function isImage(): bool
    {
        $extension = $this->resourceExtension();
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    public function isDocument(): bool
    {
        $extension = $this->resourceExtension();
        return in_array($extension, ['pdf', 'ppt', 'pptx']);
    }

    public function resourceLabel(): string
    {
        if ($this->video_url) {
            return 'Video Lesson';
        }

        if ($this->isPresentation()) {
            return 'Presentation';
        }

        if ($this->isImage()) {
            return 'Image Resource';
        }

        if ($this->isDocument()) {
            return 'Document';
        }

        return 'Text Lesson';
    }
}
