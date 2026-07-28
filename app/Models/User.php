<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'lrn',
        'password',
        'is_admin',
        'role',
        'staff_type',
        'profile_image',
        'bio',
        'location',
        'age',
        'birthday',
        'github_url',
        'linkedin_url',
        'twitter_url',
        'portfolio_url',
        'skills',
        'profile_public',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthday' => 'date',
            'password' => 'hashed',
            'skills' => 'array',
            'profile_public' => 'boolean',
            'xp' => 'integer',
            'level' => 'integer',
        ];
    }

    /**
     * Add XP to the user and adjust level if thresholds are reached.
     */
    public function addXp(int $amount): array
    {
        $this->xp = ($this->xp ?? 0) + max(0, $amount);

        // Simple leveling: every 100 XP = +1 level
        $newLevel = (int) floor($this->xp / 100) + 1;
        $gainedLevel = false;
        if ($newLevel > ($this->level ?? 1)) {
            $this->level = $newLevel;
            $gainedLevel = true;
        }

        $this->save();

        return ['xp' => $this->xp, 'level' => $this->level, 'gained_level' => $gainedLevel];
    }

    /**
     * XP left to next level.
     */
    public function getXpToNextLevelAttribute(): int
    {
        $nextThreshold = ((int) floor(($this->xp ?? 0) / 100) + 1) * 100;
        return max(0, $nextThreshold - ($this->xp ?? 0));
    }

    /**
     * Percentage progress in current level (0-100)
     */
    public function getLevelProgressPercentAttribute(): int
    {
        $current = ($this->xp ?? 0) % 100;
        return (int) round(($current / 100) * 100);
    }

    /**
     * Available staff types with labels and icons.
     */
    public const STAFF_TYPES = [
        'teacher'         => ['label' => 'Teacher',         'icon' => 'fas fa-chalkboard-teacher', 'color' => 'blue'],
        'instructor'      => ['label' => 'Instructor',      'icon' => 'fas fa-chalkboard',         'color' => 'teal'],
        'moderator'       => ['label' => 'Moderator',       'icon' => 'fas fa-shield-alt',         'color' => 'green'],
        'content_manager' => ['label' => 'Content Manager', 'icon' => 'fas fa-file-alt',           'color' => 'purple'],
        'support'         => ['label' => 'Support',         'icon' => 'fas fa-headset',            'color' => 'yellow'],
    ];

    /**
     * Get the display label for this user's staff type.
     */
    public function staffTypeLabel(): string
    {
        return self::STAFF_TYPES[$this->staff_type]['label'] ?? 'Staff';
    }

    /**
     * Check if the user is a staff member.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin || $this->role === 'admin';
    }

    /**
     * Check if the user can access teacher-specific areas.
     */
    public function isTeacher(): bool
    {
        $role = strtolower((string) ($this->role ?? ''));
        $staffType = strtolower((string) ($this->staff_type ?? ''));
        $teacherStaffTypes = ['teacher', 'instructor'];

        return $this->isAdmin()
            || $role === 'teacher'
            || in_array($staffType, $teacherStaffTypes, true);
    }

    /**
     * Check if the user has staff-level access (staff or admin).
     */
    public function hasStaffAccess(): bool
    {
        return $this->isAdmin() || in_array($this->role, ['staff', 'admin'], true) || $this->isTeacher();
    }

    /**
     * Get the user's enrollments.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Courses where the user is the instructor.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * Get the user's quiz attempts.
     */
    public function quizAttempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }
    
    /**
     * Get the user's earned badges.
     */
    public function badges()
    {
        return $this->hasMany(UserBadge::class);
    }

    /**
     * Get the courses liked by this user.
     */
    public function likedCourses()
    {
        return $this->hasMany(CourseLike::class)->with('course');
    }

    /**
     * Check if user has liked a specific course
     */
    public function hasLiked($courseId)
    {
        return $this->likedCourses()
            ->where('course_id', $courseId)
            ->exists();
    }

    /**
     * Get the user's profile guidance data (interest and skill level)
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's chatbot messages
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
