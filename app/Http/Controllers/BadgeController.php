<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\UserBadge;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    /**
     * Display all badges for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all earned badges with their related entities
        $earnedBadges = UserBadge::where('user_id', $user->id)
            ->with('badge')
            ->orderByDesc('earned_at')
            ->get();

        // Get all badge definitions for showing locked/unearned states
        $allBadges = Badge::all();

        // Gather stats
        $totalEarned = $earnedBadges->count();
        $moduleBadges = $earnedBadges->filter(fn($ub) => $ub->badge->type === 'module_completion');
        $quizBadges = $earnedBadges->filter(fn($ub) => $ub->badge->type === 'quiz_perfect');
        $courseBadges = $earnedBadges->filter(fn($ub) => $ub->badge->type === 'course_completion');

        // Build badge display data with context (course/module/quiz names)
        $badgeData = $earnedBadges->map(function ($ub) {
            $context = '';
            if ($ub->badgeable_type === Module::class) {
                $module = Module::with('course')->find($ub->badgeable_id);
                $context = $module ? $module->title . ' (' . $module->course->title . ')' : '';
            } elseif ($ub->badgeable_type === Quiz::class) {
                $quiz = Quiz::with('module.course')->find($ub->badgeable_id);
                $context = $quiz ? $quiz->title . ' (' . $quiz->module->title . ')' : '';
            } elseif ($ub->badgeable_type === Course::class) {
                $course = Course::find($ub->badgeable_id);
                $context = $course ? $course->title : '';
            }

            return [
                'user_badge' => $ub,
                'badge' => $ub->badge,
                'context' => $context,
            ];
        });

        return view('badges.badge', compact(
            'badgeData',
            'totalEarned',
            'moduleBadges',
            'quizBadges',
            'courseBadges',
            'allBadges'
        ));
    }

    /**
     * Award badges after quiz/module/course completion.
     * Called after a quiz is submitted.
     */
    public static function checkAndAwardBadges($userId, Quiz $quiz)
    {
        $awarded = [];

        // 1. Quiz Perfect Score Badge
        if ($quiz->hasUserPassed($userId) && $quiz->getUserBestScore($userId) >= 100) {
            $badge = Badge::where('type', 'quiz_perfect')->first();
            if ($badge) {
                $awarded = array_merge($awarded, self::awardBadge($userId, $badge, Quiz::class, $quiz->id));
            }
        }

        // 2. Module Completion Badge - all quizzes in the module passed
        $module = $quiz->module;
        if ($module && $module->getProgress($userId) === 100) {
            $badge = Badge::where('type', 'module_completion')->first();
            if ($badge) {
                $awarded = array_merge($awarded, self::awardBadge($userId, $badge, Module::class, $module->id));
            }

            // 3. Course Completion Badge - all modules in course completed
            $course = $module->course;
            if ($course) {
                $allModulesCompleted = $course->modules()
                    ->where('is_published', true)
                    ->get()
                    ->every(fn($m) => $m->getProgress($userId) === 100);

                if ($allModulesCompleted && $course->modules()->where('is_published', true)->count() > 0) {
                    $badge = Badge::where('type', 'course_completion')->first();
                    if ($badge) {
                        $awarded = array_merge($awarded, self::awardBadge($userId, $badge, Course::class, $course->id));
                    }
                }
            }
        }

        return $awarded;
    }

    /**
     * Award a badge to a user if not already earned for that entity.
     */
    private static function awardBadge($userId, Badge $badge, $badgeableType, $badgeableId): array
    {
        $exists = UserBadge::where('user_id', $userId)
            ->where('badge_id', $badge->id)
            ->where('badgeable_type', $badgeableType)
            ->where('badgeable_id', $badgeableId)
            ->exists();

        if (!$exists) {
            UserBadge::create([
                'user_id' => $userId,
                'badge_id' => $badge->id,
                'badgeable_type' => $badgeableType,
                'badgeable_id' => $badgeableId,
                'earned_at' => now(),
            ]);

            return [$badge];
        }

        return [];
    }
}
