<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Laravel's Notification system broadcasts to App.Models.User.{id}
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Presence channel for course editors — restrict to staff or admins
Broadcast::channel('course.{courseId}', function ($user, $courseId) {
    if (! $user) return false;
    if (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess()) {
        return ['id' => $user->id, 'name' => $user->name, 'profile_image' => $user->profile_image ?? null];
    }
    return false;
});

// Presence channel for module editors — restrict to staff or admins
Broadcast::channel('module.{moduleId}', function ($user, $moduleId) {
    if (! $user) return false;
    if (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess()) {
        return ['id' => $user->id, 'name' => $user->name, 'profile_image' => $user->profile_image ?? null];
    }
    return false;
});

// Presence channel for online staff dashboard (shows staff currently online)
Broadcast::channel('staff', function ($user) {
    if (! $user) return false;
    if (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess()) {
        return ['id' => $user->id, 'name' => $user->name, 'profile_image' => $user->profile_image ?? null];
    }
    return false;
});

?>
