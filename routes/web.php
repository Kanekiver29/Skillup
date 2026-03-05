<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\StatsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('Userpage.about');
})->name('about');

Route::get('/contact', function () {
    return view('Userpage.contact');
})->name('contact');



// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Course Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll')->middleware('auth');
Route::get('/my-learning', [CourseController::class, 'myLearning'])->name('courses.my-learning')->middleware('auth');

// Module Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}', [ModuleController::class, 'show'])->name('modules.show');
    
    // Quiz Routes
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/submit', [QuizController::class, 'submitAttempt'])->name('quizzes.submit');
    Route::get('/courses/{courseSlug}/modules/{moduleSlug}/quizzes/{quizSlug}/results/{attemptId}', [QuizController::class, 'results'])->name('quizzes.results');
    
    // Stats API Routes
    Route::get('/api/stats/course/{courseSlug}', [StatsController::class, 'courseStats']);
    Route::get('/api/stats/quiz/{courseSlug}/{moduleSlug}/{quizSlug}', [StatsController::class, 'quizStats']);
    Route::get('/api/stats/dashboard', [StatsController::class, 'userDashboardStats']);
    Route::get('/api/stats/admin/course/{courseSlug}', [StatsController::class, 'adminCourseStats']);
});

use App\Http\Controllers\RoadmapController;

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('userpage.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('userpage.profile-edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('userpage.profile-update');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('userpage.dashboard');
    
    // Roadmap Route
    Route::get('/roadmap', [RoadmapController::class, 'index'])->name('userpage.roadmap');

    // Admin Routes
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/accounts', [UserManagementController::class, 'showAdmins'])->name('admin.admins');
    Route::get('/admin/users', [UserManagementController::class, 'showUsers'])->name('admin.users');

    // placeholder reports page
    Route::get('/admin/reports', function () {
        return view('Admin.users.reports');
    })->name('admin.reports');
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/users/{user}/make-admin', [UserManagementController::class, 'makeAdmin'])->name('admin.make-admin');
    Route::delete('/admin/users/{user}/remove-admin', [UserManagementController::class, 'removeAdmin'])->name('admin.remove-admin');

    // Course management for admins
    Route::get('/admin/courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/admin/courses/create', [App\Http\Controllers\Admin\CourseController::class, 'create'])->name('admin.courses.create');
    Route::post('/admin/courses', [App\Http\Controllers\Admin\CourseController::class, 'store'])->name('admin.courses.store');
    Route::get('/admin/courses/{course}/edit', [App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('admin.courses.edit');
    Route::put('/admin/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('admin.courses.destroy');
    Route::get('/admin/courses/{course}/enrollments', [App\Http\Controllers\Admin\CourseController::class, 'enrollments'])->name('admin.courses.enrollments');

    // global enrollments overview
    Route::get('/admin/enrollments', [App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('admin.enrollments.index');
});
