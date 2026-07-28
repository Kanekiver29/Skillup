<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    /**
     * Global before: admins can do everything.
     */
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function viewAny(?User $user)
    {
        return $user && $user->hasStaffAccess();
    }

    public function view(?User $user, Course $course)
    {
        // published courses are viewable by guests; staff/admin can view all
        if ($course->is_published) {
            return true;
        }
        return $user && $user->hasStaffAccess();
    }

    public function create(User $user)
    {
        return $user->hasStaffAccess();
    }

    public function update(User $user, Course $course)
    {
        return $user->hasStaffAccess();
    }

    public function delete(User $user, Course $course)
    {
        // only full admins can permanently delete
        return $user->is_admin;
    }
}

