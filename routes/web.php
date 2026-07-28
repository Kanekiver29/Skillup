<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StaffDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TeacherManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\AIChatbotController;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route as LangRoute;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('Userpage.about');
})->name('about');

Route::get('/company/about-us', function () {
    return view('Userpage.Company.aboutus');
})->name('company.aboutus');

Route::get('/company/blog', function () {
    return view('Userpage.Company.blog');
})->name('company.blog');

Route::get('/company/careers', function () {
    return view('Userpage.Company.careers');
})->name('company.careers');

Route::get('/company/contact', function () {
    return view('Userpage.Company.contact');
})->name('company.contact');

Route::get('/contact', function () {
    return view('Userpage.contact');
})->name('contact');

Route::get('/terms', function () {
    return view('Userpage.Legal.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('Userpage.Legal.privacy');
})->name('privacy');

// Help center (simple informational page)
Route::get('/help', function () {
    return view('help.index');
})->name('help.index');

Route::get('/cookie-policy', function () {
    return view('Userpage.Legal.cookiepolicy');
})->name('cookie-policy');

Route::post('/ai-chatbot/message', [AIChatbotController::class, 'sendMessage'])->name('ai-chatbot.guest-send-message');

Route::get('/mentors', function () {
    return view('Userpage.Product.mentors');
})->name('mentors');

Route::get('/pricing', function () {
    return view('Userpage.Product.Pricing');
})->name('pricing');

Route::get('/features', function () {
    return view('Userpage.Product.features');
})->name('features');

Route::get('/learning-paths', function () {
    return view('Userpage.Product.learningpaths');
})->name('learningpaths');

// Language Switcher Route
Route::get('/lang/{locale}', function ($locale) {
    $locales = config('app.available_locales', ['en']);
    if (in_array($locale, $locales)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});


// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
// Password reset (simple dev-friendly flow)
Route::get('/password/reset', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request')->middleware('guest');
Route::post('/password/email', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('guest');
Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('/password/reset', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Course Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll')->middleware('auth');
Route::get('/my-learning', [CourseController::class, 'myLearning'])->name('courses.my-learning')->middleware('auth');

// Module Routes
Route::get('/courses/{courseSlug}/modules/{moduleSlug}', [ModuleController::class, 'show'])->name('modules.show');
Route::get('/courses/{courseSlug}/modules/{moduleSlug}/progress', [ModuleController::class, 'progress'])->name('modules.progress');

Route::middleware(['auth'])->group(function () {
    Route::post('/courses/{courseSlug}/modules/{moduleSlug}/complete', [ModuleController::class, 'markComplete'])->name('modules.markComplete');
    Route::post('/courses/{courseSlug}/modules/{moduleSlug}/track-time', [ModuleController::class, 'trackTime'])->name('modules.trackTime');
    Route::post('/courses/{courseSlug}/modules/{moduleSlug}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    // Lesson view and completion routes
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/lessons/{lessonSlug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{courseSlug}/modules/{moduleSlug}/lessons/{lessonSlug}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    // Quiz Routes
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/submit', [QuizController::class, 'submitAttempt'])->name('quizzes.submit');
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/results/{attemptId}', [QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/courses/{courseSlug}/certificate', [CertificateController::class, 'show'])->name('certificates.show');
    
    // Stats API Routes
    Route::get('/api/stats/course/{courseSlug}', [StatsController::class, 'courseStats']);
    Route::get('/api/stats/quiz/{courseSlug}/{moduleSlug}/{quizSlug}', [StatsController::class, 'quizStats']);
    Route::get('/api/stats/dashboard', [StatsController::class, 'userDashboardStats']);
    Route::get('/api/stats/admin/course/{courseSlug}', [StatsController::class, 'adminCourseStats']);
});

use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Middleware\EnsureTeacher;

Route::middleware(['auth'])->group(function () {
    // AI Chatbot Routes
    Route::get('/ai-chatbot', [AIChatbotController::class, 'index'])->name('ai-chatbot.index');
    Route::post('/ai-chatbot/send-message', [AIChatbotController::class, 'sendMessage'])->name('ai-chatbot.send-message');

    // Chat Routes
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/notifications', [ChatController::class, 'notificationsPage'])->name('notifications.index');
    Route::get('/chats/notifications', [ChatController::class, 'notifications'])->name('chats.notifications');
    Route::get('/chats/{conversation}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
    Route::patch('/chats/{conversation}/read', [ChatController::class, 'markAsRead'])->name('chats.markAsRead');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('userpage.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('userpage.profile-edit');
    // Account settings (basic account management)
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/password', [AccountController::class, 'showPasswordForm'])->name('account.password.show');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    // Ajax endpoint for live course progress stats
    Route::get('/profile/enrollments/stats', [ProfileController::class, 'enrollmentStats'])
        ->name('userpage.enrollments.stats');
    Route::put('/profile', [ProfileController::class, 'update'])->name('userpage.profile-update');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('userpage.dashboard');
    
    // Roadmap Route
    Route::get('/roadmap', [RoadmapController::class, 'index'])->name('userpage.roadmap');

    // Badge Route
    Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');

    // History Route
    Route::get('/history', [ProfileController::class, 'history'])->name('userpage.history');

    // Admin Routes
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/live-data', [DashboardController::class, 'liveData'])->name('admin.dashboard.liveData');
Route::get('/admin/staff-dashboard', [StaffDashboardController::class, 'index'])->name('admin.staff.dashboard');
    Route::get('/admin/accounts', [UserManagementController::class, 'showAdmins'])->name('admin.admins');
    Route::get('/admin/users', [UserManagementController::class, 'showUsers'])->name('admin.users.index');
    Route::get('/admin/teachers', [TeacherManagementController::class, 'index'])->name('admin.teachers.index');
    Route::post('/admin/teachers', [TeacherManagementController::class, 'store'])->name('admin.teachers.store');
    Route::delete('/admin/teachers/{user}/demote', [TeacherManagementController::class, 'demote'])->name('admin.teachers.demote');

    // Staff Admin Routes (protected by EnsureStaff middleware)
    Route::middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->group(function () {
        Route::get('/admin/staff', [StaffController::class, 'index'])->name('admin.staff.index');
        Route::get('/admin/staff/create', [StaffController::class, 'create'])->name('admin.staff.create');
        Route::get('/admin/staff/register', [StaffController::class, 'showRegister'])->name('admin.staff.register');
        Route::post('/admin/staff/register', [StaffController::class, 'register'])->name('admin.staff.register.store');
        Route::post('/admin/staff', [StaffController::class, 'store'])->name('admin.staff.store');
        Route::get('/admin/staff/{user}/transfer', [StaffController::class, 'showTransfer'])->name('admin.staff.transfer');
        Route::post('/admin/staff/{user}/transfer', [StaffController::class, 'transfer'])->name('admin.staff.transfer.update');
        Route::delete('/admin/staff/{user}/demote', [StaffController::class, 'demote'])->name('admin.staff.demote');
    });

    // Development helper: toggle current user's staff role (only when app.debug=true)
    if (config('app.debug')) {
        Route::post('/debug/toggle-staff', [\App\Http\Controllers\StaffFeatureController::class, 'toggleDebugStaff'])->name('debug.toggle-staff')->middleware('auth');
    }

    // Dedicated staff routes (staff-facing UI)
    Route::middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\StaffFeatureController::class, 'dashboard'])->name('dashboard');

        // Courses (staff)
        Route::get('/courses', [\App\Http\Controllers\staff\CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/export', [\App\Http\Controllers\staff\CourseController::class, 'export'])->name('courses.export');
        Route::get('/courses/{course}', [\App\Http\Controllers\staff\CourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/create', [\App\Http\Controllers\staff\CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [\App\Http\Controllers\staff\CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [\App\Http\Controllers\staff\CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [\App\Http\Controllers\staff\CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [\App\Http\Controllers\staff\CourseController::class, 'destroy'])->name('courses.destroy');

        // Modules (staff)
        Route::get('/modules', [\App\Http\Controllers\staff\ModuleController::class, 'index'])->name('modules.index');
        Route::get('/modules/create', [\App\Http\Controllers\staff\ModuleController::class, 'create'])->name('modules.create');
        Route::post('/modules', [\App\Http\Controllers\Admin\ModuleController::class, 'store'])->name('modules.store');
        Route::get('/modules/{module}/edit', [\App\Http\Controllers\staff\ModuleController::class, 'edit'])->name('modules.edit');
        // Inline editor used by staff (real-time)
        Route::get('/modules/{module}/editor', [\App\Http\Controllers\staff\ModuleController::class, 'editor'])->name('modules.editor');
        // API endpoint for module inline editor saves
        Route::put('/modules/{module}/api', [\App\Http\Controllers\Admin\ModuleController::class, 'apiUpdate'])->name('modules.api.update');
        Route::put('/modules/{module}', [\App\Http\Controllers\Admin\ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/modules/{module}', [\App\Http\Controllers\Admin\ModuleController::class, 'destroy'])->name('modules.destroy');

        // Lessons (staff)
        Route::get('/lessons', [\App\Http\Controllers\LessonController::class, 'create'])->name('lessons.create');
        Route::post('/lessons', [\App\Http\Controllers\LessonController::class, 'store'])->name('lessons.store');
        Route::get('/lessons/list', [\App\Http\Controllers\LessonController::class, 'index'])->name('lessons.list');
        Route::get('/lessons/archived', [\App\Http\Controllers\LessonController::class, 'archived'])->name('lessons.archived');
        Route::get('/lessons/{lesson}/edit', [\App\Http\Controllers\LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('/lessons/{lesson}', [\App\Http\Controllers\LessonController::class, 'update'])->name('lessons.update');

        // Quizzes (staff)
        Route::get('/quizzes', [\App\Http\Controllers\staff\QuizController::class, 'index'])->name('quizzes.list');
        Route::get('/quizzes/archived', [\App\Http\Controllers\staff\QuizController::class, 'archived'])->name('quizzes.archived');
        Route::get('/quizzes/create', [\App\Http\Controllers\staff\QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [\App\Http\Controllers\staff\QuizController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{quiz}/questionnaire', [\App\Http\Controllers\staff\QuizController::class, 'questionnaire'])->name('quizzes.questionnaire');
        Route::post('/quizzes/{quiz}/questionnaire', [\App\Http\Controllers\staff\QuizController::class, 'saveQuestionnaire'])->name('quizzes.questionnaire.store');
        Route::get('/quizzes/{quiz}/edit', [\App\Http\Controllers\staff\QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('/quizzes/{quiz}', [\App\Http\Controllers\staff\QuizController::class, 'update'])->name('quizzes.update');
        Route::post('/quizzes/{quiz}/archive', [\App\Http\Controllers\staff\QuizController::class, 'archive'])->name('quizzes.archive');
        Route::post('/quizzes/{quiz}/restore', [\App\Http\Controllers\staff\QuizController::class, 'restore'])->name('quizzes.restore');
        Route::delete('/quizzes/{quiz}', [\App\Http\Controllers\staff\QuizController::class, 'destroy'])->name('quizzes.destroy');

        // Staff management pages
        Route::get('/users', [\App\Http\Controllers\StaffFeatureController::class, 'users'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\StaffFeatureController::class, 'createUser'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\StaffFeatureController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\StaffFeatureController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\StaffFeatureController::class, 'updateUser'])->name('users.update');
        Route::post('/users/{user}/reset-password', [\App\Http\Controllers\StaffFeatureController::class, 'resetUserPassword'])->name('users.reset-password');
        Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\StaffFeatureController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::get('/enrollments', [\App\Http\Controllers\StaffFeatureController::class, 'enrollments'])->name('enrollments.index');
        Route::get('/reports', [\App\Http\Controllers\StaffFeatureController::class, 'dailyReports'])->name('reports.index');
        Route::get('/reports/daily', [\App\Http\Controllers\StaffFeatureController::class, 'dailyReports'])->name('reports.daily');
        Route::get('/reports/staff', [\App\Http\Controllers\StaffFeatureController::class, 'staffReports'])->name('reports.staff');
        Route::get('/resources/videos', [\App\Http\Controllers\staff\ResourceController::class, 'videos'])->name('videos.index');
        Route::get('/resources/videos/{module}/edit', [\App\Http\Controllers\staff\ResourceController::class, 'editVideo'])->name('videos.edit');
        Route::put('/resources/videos/{module}', [\App\Http\Controllers\staff\ResourceController::class, 'updateVideo'])->name('videos.update');
        Route::post('/resources/videos', [\App\Http\Controllers\staff\ResourceController::class, 'storeVideo'])->name('videos.store');
        Route::delete('/resources/videos/{module}', [\App\Http\Controllers\staff\ResourceController::class, 'destroyVideo'])->name('videos.destroy');
        Route::get('/resources/images', [\App\Http\Controllers\staff\ResourceController::class, 'images'])->name('images.index');
        Route::get('/resources/images/{module}/edit', [\App\Http\Controllers\staff\ResourceController::class, 'editImage'])->name('images.edit');
        Route::put('/resources/images/{module}', [\App\Http\Controllers\staff\ResourceController::class, 'updateImage'])->name('images.update');
        Route::post('/resources/images', [\App\Http\Controllers\staff\ResourceController::class, 'storeImage'])->name('images.store');
        Route::delete('/resources/images/{module}', [\App\Http\Controllers\staff\ResourceController::class, 'destroyImage'])->name('images.destroy');
        Route::get('/resources/powerpoints', [\App\Http\Controllers\staff\ResourceController::class, 'powerpoints'])->name('powerpoints.index');
        Route::get('/resources/powerpoints/{module}/edit', [\App\Http\Controllers\staff\ResourceController::class, 'editPowerPoint'])->name('powerpoints.edit');
        Route::put('/resources/powerpoints/{module}', [\App\Http\Controllers\staff\ResourceController::class, 'updatePowerPoint'])->name('powerpoints.update');
        Route::post('/resources/powerpoints', [\App\Http\Controllers\staff\ResourceController::class, 'storePowerPoint'])->name('powerpoints.store');
        Route::delete('/resources/powerpoints/{module}', [\App\Http\Controllers\staff\ResourceController::class, 'destroyPowerPoint'])->name('powerpoints.destroy');
        Route::get('/settings', [\App\Http\Controllers\StaffFeatureController::class, 'settings'])->name('settings.index');
        // Staff settings management (profile, security, organization, notifications)
        Route::post('/settings/profile', [\App\Http\Controllers\StaffFeatureController::class, 'updateProfile'])->name('settings.profile.update');
        Route::post('/settings/password', [\App\Http\Controllers\StaffFeatureController::class, 'changePassword'])->name('settings.password.change');
        Route::post('/settings/avatar', [\App\Http\Controllers\StaffFeatureController::class, 'uploadProfilePicture'])->name('settings.avatar.upload');
        Route::post('/settings/account', [\App\Http\Controllers\StaffFeatureController::class, 'updateAccountSettings'])->name('settings.account.update');
        Route::post('/settings/organization', [\App\Http\Controllers\StaffFeatureController::class, 'updateOrganization'])->name('settings.organization.update');
        Route::post('/settings/courses', [\App\Http\Controllers\StaffFeatureController::class, 'updateCourseSettings'])->name('settings.courses.update');
        Route::post('/settings/certificates', [\App\Http\Controllers\StaffFeatureController::class, 'updateCertificateSettings'])->name('settings.certificates.update');
        Route::post('/settings/notifications', [\App\Http\Controllers\StaffFeatureController::class, 'updateNotificationSettings'])->name('settings.notifications.update');
        Route::post('/settings/security', [\App\Http\Controllers\StaffFeatureController::class, 'updateSecuritySettings'])->name('settings.security.update');
        Route::get('/settings/activity-logs', [\App\Http\Controllers\StaffFeatureController::class, 'activityLogs'])->name('settings.activity.logs');
        Route::get('/course-records', [\App\Http\Controllers\StaffFeatureController::class, 'courseRecords'])->name('course-records.index');

        // Dashboard quick-action endpoints
        Route::post('/clock/toggle', [\App\Http\Controllers\StaffFeatureController::class, 'toggleClock'])->name('clock.toggle');

        // Tasks (simple session-backed tasks for staff)
        Route::get('/tasks', [\App\Http\Controllers\StaffFeatureController::class, 'indexTasks'])->name('tasks.index');
        Route::get('/tasks/create', [\App\Http\Controllers\StaffFeatureController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks', [\App\Http\Controllers\StaffFeatureController::class, 'storeTask'])->name('tasks.store');
        // Dismiss task (AJAX-friendly)
        Route::post('/tasks/{index}/dismiss', [\App\Http\Controllers\StaffFeatureController::class, 'dismissTask'])->name('tasks.dismiss');

        // Leave requests
        Route::get('/leave/request', [\App\Http\Controllers\StaffFeatureController::class, 'showLeaveForm'])->name('leave.request');
        Route::post('/leave/request', [\App\Http\Controllers\StaffFeatureController::class, 'submitLeaveRequest'])->name('leave.submit');

        // Schedule and support pages
        Route::get('/schedule', [\App\Http\Controllers\StaffFeatureController::class, 'schedule'])->name('schedule.index');
        Route::get('/attendance', [\App\Http\Controllers\StaffFeatureController::class, 'attendance'])->name('attendance.index');
        Route::get('/support', [\App\Http\Controllers\StaffFeatureController::class, 'contactSupport'])->name('support.index');
        Route::post('/support', [\App\Http\Controllers\StaffFeatureController::class, 'sendSupport'])->name('support.send');
        // Export enrollments (staff)
        Route::get('/enrollments/export', [\App\Http\Controllers\StaffFeatureController::class, 'exportEnrollments'])->name('enrollments.export');
        // Enrollment resource actions (staff)
        Route::post('/enrollments', [\App\Http\Controllers\StaffFeatureController::class, 'storeEnrollment'])->name('enrollments.store');
        Route::get('/enrollments/{enrollment}', [\App\Http\Controllers\StaffFeatureController::class, 'showEnrollment'])->name('enrollments.show');
        Route::get('/enrollments/{enrollment}/edit', [\App\Http\Controllers\StaffFeatureController::class, 'editEnrollment'])->name('enrollments.edit');
        Route::put('/enrollments/{enrollment}', [\App\Http\Controllers\StaffFeatureController::class, 'updateEnrollment'])->name('enrollments.update');
        Route::delete('/enrollments/{enrollment}', [\App\Http\Controllers\StaffFeatureController::class, 'destroyEnrollment'])->name('enrollments.destroy');
    });

    // Teacher routes loaded from separate file to keep web.php tidy
    if (file_exists(base_path('routes/teacher.php'))) {
        require base_path('routes/teacher.php');
    }

    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('admin.reports');
    Route::get('/admin/reports/export', [App\Http\Controllers\Admin\ReportsController::class, 'exportExcel'])->name('admin.reports.export');
    Route::get('/admin/reports/live-data', [App\Http\Controllers\Admin\ReportsController::class, 'liveEnrollmentData'])->name('admin.reports.liveData');

    // Excel Reports Routes
    Route::get('/admin/excel-reports', [App\Http\Controllers\Admin\ExcelReportsController::class, 'index'])->name('admin.excel.index');
    Route::get('/admin/excel-reports/export-users', [App\Http\Controllers\Admin\ExcelReportsController::class, 'exportUsersReport'])->name('admin.excel.export-users');
    Route::get('/admin/excel-reports/export-users-courses', [App\Http\Controllers\Admin\ExcelReportsController::class, 'exportUsersCourses'])->name('admin.excel.export-users-courses');
    Route::get('/admin/excel-reports/export-enrollment', [App\Http\Controllers\Admin\ExcelReportsController::class, 'exportEnrollmentReport'])->name('admin.excel.export-enrollment');
    Route::get('/admin/excel-reports/realtime-data', [App\Http\Controllers\Admin\ExcelReportsController::class, 'getRealTimeData'])->name('admin.excel.realtime-data');

    Route::get('/admin/archive', function () {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $modelUsesSoftDeletes = in_array(EloquentSoftDeletes::class, class_uses_recursive(User::class), true);
        $tableHasDeletedAt = Schema::hasColumn('users', 'deleted_at');
        $archiveReady = $modelUsesSoftDeletes && $tableHasDeletedAt;

        $archivedUsers = $archiveReady
            ? User::onlyTrashed()->latest('deleted_at')->paginate(10)
            : collect();

        return view('Admin.archive', [
            'archiveReady' => $archiveReady,
            'archivedUsers' => $archivedUsers,
            'archivedCount' => $archiveReady ? User::onlyTrashed()->count() : 0,
            'hasRestoreRoute' => Route::has('admin.users.restore'),
            'hasForceDeleteRoute' => Route::has('admin.users.force-delete'),
        ]);
    })->name('admin.archive');

    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/users/{user}/restore', [UserManagementController::class, 'restoreUser'])->name('admin.users.restore');
    Route::delete('/admin/users/{user}/force-delete', [UserManagementController::class, 'forceDeleteUser'])->name('admin.users.force-delete');
    // Use {id} here so implicit model binding doesn't attempt to resolve
    // a non-existent (trashed) model and cause a 404 before the
    // controller can handle archived users.
    Route::get('/admin/users/{id}/archived', [UserManagementController::class, 'showArchivedUser'])->name('admin.users.archived-detail');
    Route::post('/admin/users/{user}/make-admin', [UserManagementController::class, 'makeAdmin'])->name('admin.make-admin');
    Route::delete('/admin/users/{user}/remove-admin', [UserManagementController::class, 'removeAdmin'])->name('admin.remove-admin');

    // Course management for admins
    Route::middleware([\App\Http\Middleware\EnsureAdmin::class])->group(function () {
        Route::get('/admin/courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.courses.index');
        Route::get('/admin/courses/create', [App\Http\Controllers\Admin\CourseController::class, 'create'])->name('admin.courses.create');
        Route::post('/admin/courses', [App\Http\Controllers\Admin\CourseController::class, 'store'])->name('admin.courses.store');
        Route::get('/admin/courses/{course}/edit', [App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('admin.courses.edit');
        Route::put('/admin/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'update'])->name('admin.courses.update');
        Route::delete('/admin/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('admin.courses.destroy');
        Route::get('/admin/courses/{course}/enrollments', [App\Http\Controllers\Admin\CourseController::class, 'enrollments'])->name('admin.courses.enrollments');
    });

    // Module management (admin-only)
    Route::middleware([\App\Http\Middleware\EnsureAdmin::class])->group(function () {
        Route::get('/admin/modules', [App\Http\Controllers\Admin\ModuleController::class, 'index'])->name('admin.modules.index');
        Route::get('/admin/modules/create', [App\Http\Controllers\Admin\ModuleController::class, 'create'])->name('admin.modules.create');
        Route::post('/admin/modules', [App\Http\Controllers\Admin\ModuleController::class, 'store'])->name('admin.modules.store');
        Route::get('/admin/modules/{module}/edit', [App\Http\Controllers\Admin\ModuleController::class, 'edit'])->name('admin.modules.edit');
        Route::put('/admin/modules/{module}', [App\Http\Controllers\Admin\ModuleController::class, 'update'])->name('admin.modules.update');
        Route::delete('/admin/modules/{module}', [App\Http\Controllers\Admin\ModuleController::class, 'destroy'])->name('admin.modules.destroy');
        Route::post('/admin/modules/{module}/restore', [App\Http\Controllers\Admin\ModuleController::class, 'restore'])->name('admin.modules.restore');
        Route::delete('/admin/modules/{module}/force-delete', [App\Http\Controllers\Admin\ModuleController::class, 'forceDelete'])->name('admin.modules.force-delete');
    });

    // Content Creation Routes (Assessment, Video, Presentation, etc.)
    Route::post('/admin/content/assessment', [App\Http\Controllers\Admin\ContentController::class, 'createAssessment'])->name('admin.content.assessment');
    Route::post('/admin/content/video', [App\Http\Controllers\Admin\ContentController::class, 'createVideo'])->name('admin.content.video');
    Route::post('/admin/content/presentation', [App\Http\Controllers\Admin\ContentController::class, 'createPresentation'])->name('admin.content.presentation');
    Route::post('/admin/content/quiz', [App\Http\Controllers\Admin\ContentController::class, 'createQuiz'])->name('admin.content.quiz');
    Route::post('/admin/content/powerpoint', [App\Http\Controllers\Admin\ContentController::class, 'createPowerPoint'])->name('admin.content.powerpoint');
    Route::post('/admin/content/images', [App\Http\Controllers\Admin\ContentController::class, 'uploadImages'])->name('admin.content.images');
    Route::get('/admin/content/modules', [App\Http\Controllers\Admin\ContentController::class, 'getModules'])->name('admin.content.modules');

    // global enrollments overview
    Route::get('/admin/enrollments', [App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('admin.enrollments.index');

    // Admin Profile
    Route::get('/admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('/admin/profile/live-data', [AdminProfileController::class, 'liveData'])->name('admin.profile.liveData');
    Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/admin/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');

    // Admin Chat Routes
    Route::get('/admin/chats', [AdminChatController::class, 'index'])->name('admin.chats.index');
    Route::get('/admin/chats/notifications', [AdminChatController::class, 'notifications'])->name('admin.chats.notifications');
    Route::get('/admin/chats/active-users', [AdminChatController::class, 'active'])->name('admin.chats.active');
    Route::get('/admin/chats/{conversation}', [AdminChatController::class, 'show'])->name('admin.chats.show');
    Route::post('/admin/chats', [AdminChatController::class, 'store'])->name('admin.chats.store');
    Route::patch('/admin/chats/{conversation}/read', [AdminChatController::class, 'markAsRead'])->name('admin.chats.markAsRead');
    Route::get('/api/admin/users', [AdminChatController::class, 'active'])->name('api.admin.users');

    // Settings
    Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/admin/settings/cache', [App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('admin.settings.cache.clear');
    Route::post('/admin/settings/maintenance', [App\Http\Controllers\Admin\SettingsController::class, 'toggleMaintenance'])->name('admin.settings.maintenance');

    // System Logs
    Route::get('/admin/system-logs', [App\Http\Controllers\Admin\SystemLogController::class, 'index'])->name('admin.systemlog');
    Route::post('/admin/system-logs/clear', [App\Http\Controllers\Admin\SystemLogController::class, 'clear'])->name('admin.systemlog.clear');
    Route::get('/admin/system-logs/download', [App\Http\Controllers\Admin\SystemLogController::class, 'download'])->name('admin.systemlog.download');

    // Admin Legal / Help Pages
    Route::get('/admin/help', function () {
        return view('Admin.Legal.help');
    })->name('admin.help');

    Route::get('/admin/privacy', function () {
        return view('Admin.Legal.privacy');
    })->name('admin.privacy');

    Route::get('/admin/terms', function () {
        return view('Admin.Legal.terms');
    })->name('admin.terms');

    // Database overview
    Route::get('/admin/database', function () {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $databaseName = config("database.connections.{$connection}.database") ?: 'N/A';

        $connectionStatus = true;
        $connectionError = null;
        $tableStats = collect();
        $totalTables = 0;
        $totalRows = 0;
        $totalSizeMb = 0.0;

        try {
            DB::select('SELECT 1');

            if ($driver === 'mysql' && $databaseName !== 'N/A') {
                $tableStats = collect(DB::select(
                    'SELECT table_name, engine, table_rows, data_length, index_length, create_time, update_time
                     FROM information_schema.tables
                     WHERE table_schema = ?
                     ORDER BY (data_length + index_length) DESC, table_name ASC',
                    [$databaseName]
                ))->map(function ($table) {
                    $dataLength = (int) ($table->data_length ?? 0);
                    $indexLength = (int) ($table->index_length ?? 0);
                    $rows = (int) ($table->table_rows ?? 0);
                    $sizeBytes = $dataLength + $indexLength;

                    return [
                        'name' => (string) $table->table_name,
                        'engine' => (string) ($table->engine ?? 'N/A'),
                        'rows' => $rows,
                        'size_mb' => round($sizeBytes / 1024 / 1024, 2),
                        'created_at' => $table->create_time,
                        'updated_at' => $table->update_time,
                    ];
                });
            } else {
                $tableStats = collect(Schema::getTableListing())->map(function ($tableName) {
                    return [
                        'name' => $tableName,
                        'engine' => 'N/A',
                        'rows' => 0,
                        'size_mb' => 0,
                        'created_at' => null,
                        'updated_at' => null,
                    ];
                });
            }

            $totalTables = $tableStats->count();
            $totalRows = (int) $tableStats->sum('rows');
            $totalSizeMb = (float) $tableStats->sum('size_mb');
        } catch (\Throwable $e) {
            $connectionStatus = false;
            $connectionError = $e->getMessage();
        }

        return view('Admin.database', [
            'connection' => $connection,
            'driver' => $driver,
            'databaseName' => $databaseName,
            'connectionStatus' => $connectionStatus,
            'connectionError' => $connectionError,
            'tableStats' => $tableStats,
            'totalTables' => $totalTables,
            'totalRows' => $totalRows,
            'totalSizeMb' => $totalSizeMb,
            'lastUpdated' => now(),
        ]);
    })->name('admin.database');

    // Backup and recovery module
    Route::get('/admin/backup', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('admin.backup.index');
    Route::post('/admin/backup', [App\Http\Controllers\Admin\BackupController::class, 'store'])->name('admin.backup.store');
    Route::post('/admin/backup/full', [App\Http\Controllers\Admin\BackupController::class, 'fullBackup'])->name('admin.backup.fullBackup');
    Route::get('/admin/backup/download/{file}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('admin.backup.download');
    Route::post('/admin/backup/restore', [App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('admin.backup.restore');

});

        // (legacy simple staff routes removed — dedicated staff routes exist above)