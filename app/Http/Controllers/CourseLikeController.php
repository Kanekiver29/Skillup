<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLikeController extends Controller
{
    /**
     * Toggle like status for a course
     */
    public function toggle(Request $request, $courseId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        // Check if user has already liked the course
        $like = CourseLike::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($like) {
            // Unlike the course
            $like->delete();
            $liked = false;
        } else {
            // Like the course
            CourseLike::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $course->getLikesCount(),
        ]);
    }

    /**
     * Get like status for a course
     */
    public function status($courseId)
    {
        if (!Auth::check()) {
            return response()->json([
                'liked' => false,
                'likes_count' => Course::findOrFail($courseId)->getLikesCount(),
            ]);
        }

        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        return response()->json([
            'liked' => $course->isLikedBy($user->id),
            'likes_count' => $course->getLikesCount(),
        ]);
    }

    /**
     * Get top liked courses
     */
    public function topLiked($limit = 10)
    {
        $courses = Course::where('is_published', true)
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'likes_count' => $course->likes_count,
                    'liked' => Auth::check() ? $course->isLikedBy(Auth::id()) : false,
                ];
            });

        return response()->json([
            'success' => true,
            'courses' => $courses,
        ]);
    }

    /**
     * Get user's liked courses
     */
    public function userLiked()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $courses = $user->likedCourses()
            ->get()
            ->map(function ($like) {
                $course = $like->course;
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'description' => $course->short_description,
                    'likes_count' => $course->getLikesCount(),
                ];
            });

        return response()->json([
            'success' => true,
            'courses' => $courses,
        ]);
    }
}
