<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AttendanceMonitoringController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeManagementController;
use App\Http\Controllers\Admin\ScheduleManagementController;
use App\Http\Controllers\Admin\SectionManagementController;
use App\Http\Controllers\Admin\StaffDashboardController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\SubjectManagementController;
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
use App\Http\Controllers\SiasStudentTeacherEvaluationController;
use App\Http\Controllers\SiasTeacherGradeController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\AIChatbotController;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route as LangRoute;
use App\Http\Middleware\EnsureTeacher;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureSiasAdmin;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news');

Route::get('/news/index', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [App\Http\Controllers\NewsController::class, 'create'])->name('news.create');
Route::post('/news', [App\Http\Controllers\NewsController::class, 'store'])->name('news.store');
Route::get('/news/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
Route::post('/news/{id}/react', [App\Http\Controllers\NewsController::class, 'react'])->name('news.react');
Route::post('/news/{id}/comment', [App\Http\Controllers\NewsController::class, 'storeComment'])->name('news.comment');
Route::get('/news/{id}/edit', [App\Http\Controllers\NewsController::class, 'edit'])->name('news.edit');
Route::put('/news/{id}', [App\Http\Controllers\NewsController::class, 'update'])->name('news.update');
Route::delete('/news/{id}', [App\Http\Controllers\NewsController::class, 'destroy'])->name('news.destroy');

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

Route::get('/developer', function () {
    return view('Userpage.developer');
})->name('developer');

Route::get('/career', function () {
    return view('Userpage.career');
})->name('career');

Route::get('/advertising', function () {
    return view('Userpage.advesticing');
})->name('advertising');

Route::get('/licensing', function () {
    return view('Userpage.licensing');
})->name('licensing');

// Help center (simple informational page)
Route::get('/help', function () {
    return view('help.index');
})->name('help.index');

Route::get('/help/career', function () {
    return view('help.career');
})->name('help.career');

Route::get('/cookie-policy', function () {
    return view('Userpage.Legal.cookiepolicy');
})->name('cookie-policy');

Route::post('/ai-chatbot/message', [AIChatbotController::class, 'sendMessage'])->name('ai-chatbot.guest-send-message');

Route::get('/pricing', function () {
    return view('Userpage.Product.Pricing');
})->name('pricing');

Route::get('/features', function () {
    return view('Userpage.Product.features');
})->name('features');
Route::get('/how-it-works', function () {
    return view('Userpage.Product.how-it-works');
})->name('how-it-works');
Route::get('/faq', function () {
    return view('Userpage.Product.faq');
})->name('faq');

Route::get('/learning-paths', function () {
    return view('Userpage.Product.learningpaths');
})->name('learningpaths');

// Course & Learning Routes
Route::get('/quiz', [\App\Http\Controllers\CourseController::class, 'quiz'])->name('quiz');
Route::post('/quiz/{quiz}/submit', [\App\Http\Controllers\CourseController::class, 'submitQuiz'])->name('quiz.submit');
Route::get('/subjects', [\App\Http\Controllers\CourseController::class, 'subjects'])->name('subjects');
Route::get('/courses-subjects', [\App\Http\Controllers\CourseController::class, 'subjects'])->name('courses.subjects');
Route::get('/trivia', [\App\Http\Controllers\CourseController::class, 'trivia'])->name('trivia');
Route::post('/trivia/quick-play/scores', [\App\Http\Controllers\CourseController::class, 'submitTriviaQuickPlayScore'])
    ->middleware('auth')
    ->name('trivia.quick-play.scores');
Route::get('/lesson', function () {
    return redirect()->route('courses.index');
})->name('lesson');
Route::get('/exam', function () { return view('Userpage.course.exam'); })->name('exam');
Route::get('/grades', function () {
    $enrollments = auth()->check()
        ? \App\Models\Enrollment::where('user_id', auth()->id())->with(['course', 'subject'])->get()
        : collect();
    return view('Userpage.course.grades', compact('enrollments'));
})->name('grades');

// Language Switcher Route
Route::get('/lang/{locale}', function ($locale) {
    $locales = config('app.available_locales', ['en']);
    if (in_array($locale, $locales)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');


// Auth Routes
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login')->middleware('guest');
Route::get('/sias/admin/login', [AuthController::class, 'showPortalLogin'])->defaults('portal', 'sias-admin')->name('sias.admin.login')->middleware('guest');
Route::post('/sias/admin/login', [AuthController::class, 'portalLogin'])->defaults('portal', 'sias-admin')->name('sias.admin.login.submit')->middleware('guest');
Route::get('/course/login', \App\Livewire\Auth\Login::class)->name('course.login')->middleware('guest');
Route::get('/sias/login', function (Illuminate\Http\Request $request) {
    $role = $request->query('role', 'student');
    if (! in_array($role, ['admin', 'teacher', 'student'], true)) {
        $role = 'student';
    }
    return view('sias.login.login', ['defaultRole' => $role]);
})->name('sias.login')->middleware('guest');
Route::post('/sias/login', [AuthController::class, 'siasLogin'])->name('sias.login.submit')->middleware('guest');
Route::get('/sias/login/admin', function () {
    return redirect()->route('sias.login', ['role' => 'admin']);
})->name('sias.login.admin')->middleware('guest');
Route::get('/sias/login/teacher', function () {
    return redirect()->route('sias.login', ['role' => 'teacher']);
})->name('sias.login.teacher')->middleware('guest');
Route::get('/sias/login/student', function () {
    return redirect()->route('sias.login', ['role' => 'student']);
})->name('sias.login.student')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// SIAS Student Pages
// Enrollment page shows login for guests and enrollment status for authenticated students.
Route::get('/sias/student/enrollment', function () { return view('sias.students.enrollment.index'); })->name('sias.student.enrollment');
Route::post('/sias/student/enrollment', [App\Http\Controllers\AuthController::class, 'enrollStudent'])->middleware('guest');

Route::middleware(['auth'])->prefix('sias/student')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SiasStudentDashboardController::class, 'index'])->name('sias.student.dashboard');
    Route::view('/profile', 'sias.students.profile.index')->name('sias.student.profile');
    
    // Profile Pages - GET
    Route::get('/profile/personal-information', function () { return view('sias.students.profile.personal_information'); })->name('sias.student.profile.personal_information');
    Route::get('/profile/addresses-contacts', function () { return view('sias.students.profile.addresses_contacts'); })->name('sias.student.profile.addresses_contacts');
    Route::get('/profile/family-background', function () { return view('sias.students.profile.family_background'); })->name('sias.student.profile.family_background');
    Route::get('/profile/educational-background', function () { return view('sias.students.profile.educational_background'); })->name('sias.student.profile.educational_background');
    Route::get('/profile/religious-background', function () { return view('sias.students.profile.religious_background'); })->name('sias.student.profile.religious_background');
    Route::get('/profile/medical-information', function () { return view('sias.students.profile.medical_information'); })->name('sias.student.profile.medical_information');
    Route::get('/profile/employment-records', function () { return view('sias.students.profile.employment_records'); })->name('sias.student.profile.employment_records');
    Route::get('/profile/classifications-disabilities', function () { return view('sias.students.profile.classifications_disabilities'); })->name('sias.student.profile.classifications_disabilities');
    
    // Profile Pages - POST (Form Submissions)
    Route::post('/profile/personal-information', [\App\Http\Controllers\SiasStudentProfileController::class, 'updatePersonalInformation'])->name('sias.student.profile.personal_information.update');
    Route::post('/profile/addresses-contacts', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateAddressesContacts'])->name('sias.student.profile.addresses_contacts.update');
    Route::post('/profile/family-background', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateFamilyBackground'])->name('sias.student.profile.family_background.update');
    Route::post('/profile/educational-background', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateEducationalBackground'])->name('sias.student.profile.educational_background.update');
    Route::post('/profile/religious-background', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateReligiousBackground'])->name('sias.student.profile.religious_background.update');
    Route::post('/profile/medical-information', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateMedicalInformation'])->name('sias.student.profile.medical_information.update');
    Route::post('/profile/employment-records', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateEmploymentRecords'])->name('sias.student.profile.employment_records.update');
    Route::post('/profile/classifications-disabilities', [\App\Http\Controllers\SiasStudentProfileController::class, 'updateClassificationsDisabilities'])->name('sias.student.profile.classifications_disabilities.update');
    Route::get('/registration', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'index'])->name('sias.student.registration');
    Route::post('/registration/course', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'storeCourse'])->name('sias.student.registration.course');
    Route::post('/registration/subjects', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'storeSubjects'])->name('sias.student.registration.subjects');
    Route::post('/registration/reset', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'reset'])->name('sias.student.registration.reset');
    Route::get('/registration/enrollment-form', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'enrollmentForm'])->name('sias.student.registration.enrollment_form');
    Route::get('/registration/assessment-form', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'assessmentForm'])->name('sias.student.registration.assessment_form');
    Route::get('/registration/enrollment-certificate', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'enrollmentCertificate'])->name('sias.student.registration.enrollment_certificate');
    Route::get('/registration/assessment-certificate', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'assessmentCertificate'])->name('sias.student.registration.assessment_certificate');
    Route::get('/registration/grade-certificate', [\App\Http\Controllers\SiasStudentRegistrationController::class, 'gradeCertificate'])->name('sias.student.registration.grade_certificate');
    Route::get('/assessment', [\App\Http\Controllers\SiasStudentAssessmentController::class, 'index'])->name('sias.student.assessment');
    Route::get('/teacher-evaluation', [SiasStudentTeacherEvaluationController::class, 'index'])->name('sias.student.teacher_evaluation');
    Route::get('/teacher-evaluation/{enrollment}/create', [SiasStudentTeacherEvaluationController::class, 'create'])->name('sias.student.teacher_evaluation.create');
    Route::post('/teacher-evaluation/{enrollment}', [SiasStudentTeacherEvaluationController::class, 'store'])->name('sias.student.teacher_evaluation.store');
    Route::get('/teacher-evaluation/{enrollment}/review', [SiasStudentTeacherEvaluationController::class, 'show'])->name('sias.student.teacher_evaluation.show');
    Route::view('/subjects', 'sias.students.subjects.index')->name('sias.student.subjects');
    Route::get('/schedule', [\App\Http\Controllers\SiasStudentScheduleController::class, 'index'])->name('sias.student.schedule');
    Route::get('/grades', [\App\Http\Controllers\SiasStudentGradesController::class, 'index'])->name('sias.student.grades');
    Route::get('/attendance', [\App\Http\Controllers\SiasStudentAttendanceController::class, 'index'])->name('sias.student.attendance');
    Route::get('/reports', [\App\Http\Controllers\SiasStudentReportsController::class, 'index'])->name('sias.student.reports');
    Route::get('/reports/{section}/print', [\App\Http\Controllers\SiasStudentReportsController::class, 'print'])->name('sias.student.reports.print');
    Route::get('/reports/class-offerings', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.class-offerings')->defaults('section', 'class-offerings');
    Route::get('/reports/enrolled-subjects', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.enrolled-subjects')->defaults('section', 'enrolled-subjects');
    Route::get('/reports/final-grades-match', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.final-grades-match')->defaults('section', 'final-grades-match');
    Route::get('/reports/final-grades-ignore', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.final-grades-ignore')->defaults('section', 'final-grades-ignore');
    Route::get('/reports/gwa-match', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.gwa-match')->defaults('section', 'gwa-match');
    Route::get('/reports/gwa-ignore', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.gwa-ignore')->defaults('section', 'gwa-ignore');
    Route::get('/reports/term-grades-match', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.term-grades-match')->defaults('section', 'term-grades-match');
    Route::get('/reports/term-grades-ignore', [\App\Http\Controllers\SiasStudentReportsController::class, 'show'])->name('sias.student.reports.term-grades-ignore')->defaults('section', 'term-grades-ignore');
    Route::get('/announcements', function () {
        $announcements = \App\Models\NewsItem::published()
            ->where(function ($query) {
                $query->whereNull('target_audience')
                    ->orWhere('target_audience', 'like', '%student%')
                    ->orWhere('target_audience', 'like', '%all%');
            })
            ->latest('published_at')
            ->get();

        return view('sias.students.announcements.index', compact('announcements'));
    })->name('sias.student.announcements');
    Route::get('/documents', [\App\Http\Controllers\SiasStudentDocumentsController::class, 'index'])->name('sias.student.documents');
    Route::post('/documents', [\App\Http\Controllers\SiasStudentDocumentsController::class, 'store'])->name('sias.student.documents.store');
    Route::delete('/documents/{studentDocumentRequest}', [\App\Http\Controllers\SiasStudentDocumentsController::class, 'destroy'])->name('sias.student.documents.destroy');
    Route::get('/documents/{studentDocumentRequest}/download', [\App\Http\Controllers\SiasStudentDocumentsController::class, 'download'])->name('sias.student.documents.download');
    Route::get('/notifications', function () {
        return view('sias.students.notifications.index');
    })->name('sias.student.notifications');
    Route::view('/help', 'sias.students.help.index')->name('sias.student.help');
    Route::view('/account', 'sias.students.account.index')->name('sias.student.account');
    Route::get('/settings', [\App\Http\Controllers\UserSettingsController::class, 'index'])->name('sias.student.settings');
    Route::post('/settings', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('sias.student.settings.update');
    Route::view('/account/password', 'sias.students.account.password')->name('sias.student.account.password');
    Route::get('/account/mfa', [\App\Http\Controllers\SiasStudentMfaController::class, 'index'])->name('sias.student.account.mfa');
    Route::post('/account/mfa/toggle', [\App\Http\Controllers\SiasStudentMfaController::class, 'toggle'])->name('sias.student.account.mfa.toggle');
});

// SIAS Teacher Pages
Route::middleware(['auth', EnsureTeacher::class])->prefix('sias/teacher')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SiasTeacherDashboardController::class, 'index'])->name('sias.teacher.dashboard');
    Route::get('/dashboard/data', [\App\Http\Controllers\SiasTeacherDashboardController::class, 'getData'])->name('sias.teacher.dashboard.data');
    Route::get('/programs', [\App\Http\Controllers\SiasTeacherPortalController::class, 'programs'])->name('sias.teacher.programs');
    Route::get('/classes', [\App\Http\Controllers\SiasTeacherPortalController::class, 'classes'])->name('sias.teacher.classes');
    Route::get('/trainees', [\App\Http\Controllers\SiasTeacherPortalController::class, 'trainees'])->name('sias.teacher.trainees');
    Route::get('/attendance', [\App\Http\Controllers\SiasTeacherPortalController::class, 'attendance'])->name('sias.teacher.attendance');
    Route::post('/attendance', [\App\Http\Controllers\SiasTeacherPortalController::class, 'storeAttendance'])->name('sias.teacher.attendance.store');
    Route::get('/competency', [\App\Http\Controllers\SiasTeacherPortalController::class, 'competency'])->name('sias.teacher.competency');
    Route::get('/assessments', [\App\Http\Controllers\SiasTeacherPortalController::class, 'assessments'])->name('sias.teacher.assessments');
    Route::get('/materials', [\App\Http\Controllers\SiasTeacherPortalController::class, 'materials'])->name('sias.teacher.materials');
    Route::get('/progress', [\App\Http\Controllers\SiasTeacherPortalController::class, 'progress'])->name('sias.teacher.progress');
    Route::get('/reports', [\App\Http\Controllers\SiasTeacherPortalController::class, 'reports'])->name('sias.teacher.reports');
    Route::get('/announcements', [\App\Http\Controllers\SiasTeacherPortalController::class, 'announcements'])->name('sias.teacher.announcements');
    Route::get('/profile', [\App\Http\Controllers\SiasTeacherProfileController::class, 'index'])->name('sias.teacher.profile');
    Route::get('/settings', [\App\Http\Controllers\UserSettingsController::class, 'index'])->name('sias.teacher.settings');
    Route::post('/settings', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('sias.teacher.settings.update');
    Route::get('/profile/create-course', [\App\Http\Controllers\SiasTeacherProfileController::class, 'create'])->name('sias.teacher.profile.create-course');
    Route::post('/profile/courses', [\App\Http\Controllers\SiasTeacherProfileController::class, 'store'])->name('sias.teacher.profile.store-course');
    Route::get('/profile/courses/{course}/edit', [\App\Http\Controllers\SiasTeacherProfileController::class, 'edit'])->name('sias.teacher.profile.edit-course');
    Route::put('/profile/courses/{course}', [\App\Http\Controllers\SiasTeacherProfileController::class, 'update'])->name('sias.teacher.profile.update-course');
    Route::delete('/profile/courses/{course}', [\App\Http\Controllers\SiasTeacherProfileController::class, 'destroy'])->name('sias.teacher.profile.destroy-course');
    Route::post('/profile/courses/{course}/publish', [\App\Http\Controllers\SiasTeacherProfileController::class, 'publish'])->name('sias.teacher.profile.publish-course');
    Route::post('/profile/courses/{course}/unpublish', [\App\Http\Controllers\SiasTeacherProfileController::class, 'unpublish'])->name('sias.teacher.profile.unpublish-course');
    Route::post('/profile/courses/{course}/assign-student', [\App\Http\Controllers\SiasTeacherProfileController::class, 'assignStudent'])->name('sias.teacher.profile.assign-student');
    Route::post('/profile/courses/{course}/remove-student', [\App\Http\Controllers\SiasTeacherProfileController::class, 'removeStudent'])->name('sias.teacher.profile.remove-student');
    Route::get('/subjects', [SiasTeacherGradeController::class, 'subjects'])->name('sias.teacher.subjects');
    Route::get('/monitoring-class', 'App\Http\Controllers\SiasTeacherGradeController@monitoringClass')->name('sias.teacher.monitoring-class');
    Route::get('/grade-entry', [SiasTeacherGradeController::class, 'index'])->name('sias.teacher.grade-entry');
    Route::get('/schedule', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'index'])->name('sias.teacher.schedule');
    Route::get('/schedule/create', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'create'])->name('sias.teacher.schedule.create');
    Route::post('/schedule', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'store'])->name('sias.teacher.schedule.store');
    Route::get('/schedule/{schedule}/edit', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'edit'])->name('sias.teacher.schedule.edit');
    Route::put('/schedule/{schedule}', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'update'])->name('sias.teacher.schedule.update');
    Route::delete('/schedule/{schedule}', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'destroy'])->name('sias.teacher.schedule.destroy');
    Route::post('/schedule/{schedule}/toggle', [\App\Http\Controllers\SiasTeacherScheduleController::class, 'toggle'])->name('sias.teacher.schedule.toggle');
    Route::get('/grades', [SiasTeacherGradeController::class, 'index'])->name('sias.teacher.grades.index');
    Route::patch('/grades/{enrollment}', [SiasTeacherGradeController::class, 'update'])->name('sias.teacher.grades.update');
    Route::view('/account', 'sias.teacher.account.index')->name('sias.teacher.account');
    Route::view('/account/password', 'sias.teacher.account.password')->name('sias.teacher.account.password');
    Route::put('/account/password', [\App\Http\Controllers\AccountController::class, 'updatePassword'])->name('sias.teacher.account.password.update');
});

// SIAS Admin Pages
Route::middleware(['auth', EnsureSiasAdmin::class])->prefix('sias/admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('sias.admin.dashboard');
    Route::get('/dashboard/live-data', [DashboardController::class, 'liveData'])->name('admin.liveData');
    Route::view('/users', 'sias.admin.users.index')->name('sias.admin.users');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserManagementController::class, 'createUser'])->name('sias.admin.users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'storeUser'])->name('sias.admin.users.store');
    Route::get('/teachers', [\App\Http\Controllers\Admin\TeacherManagementController::class, 'indexSias'])->name('sias.admin.teachers');
    Route::get('/teachers/create', [\App\Http\Controllers\Admin\TeacherManagementController::class, 'createSias'])->name('sias.admin.teachers.create');
    Route::post('/teachers', [\App\Http\Controllers\Admin\TeacherManagementController::class, 'storeSias'])->name('sias.admin.teachers.store');
    Route::get('/teachers/{user}/edit', [\App\Http\Controllers\Admin\TeacherManagementController::class, 'editSias'])->name('sias.admin.teachers.edit');
    Route::put('/teachers/{user}', [\App\Http\Controllers\Admin\TeacherManagementController::class, 'updateSias'])->name('sias.admin.teachers.update');
    Route::delete('/teachers/{user}/demote', [\App\Http\Controllers\Admin\TeacherManagementController::class, 'demoteSias'])->name('sias.admin.teachers.demote');
    // SIAS admin student management (wire sidebar link)
    Route::get('/students', [\App\Http\Controllers\Admin\StudentManagementController::class, 'index'])->name('sias.admin.students.index');
    Route::get('/students/create', [\App\Http\Controllers\Admin\StudentManagementController::class, 'create'])->name('sias.admin.students.create');
    Route::post('/students', [\App\Http\Controllers\Admin\StudentManagementController::class, 'store'])->name('sias.admin.students.store');
    Route::get('/students/profiles', [\App\Http\Controllers\Admin\StudentManagementController::class, 'profiles'])->name('sias.admin.students.profiles');
    Route::get('/students/documents', [\App\Http\Controllers\Admin\StudentManagementController::class, 'documents'])->name('sias.admin.students.documents');
    Route::get('/students/status', [\App\Http\Controllers\Admin\StudentManagementController::class, 'status'])->name('sias.admin.students.status');
    Route::get('/students/{student}', [\App\Http\Controllers\Admin\StudentManagementController::class, 'show'])->name('sias.admin.students.show');
    Route::get('/students/{student}/print', [\App\Http\Controllers\Admin\StudentManagementController::class, 'print'])->name('sias.admin.students.print');
    Route::get('/students/{student}/enrollment-certificate', [\App\Http\Controllers\Admin\StudentManagementController::class, 'enrollmentCertificate'])->name('sias.admin.students.enrollment-certificate');
    Route::get('/students/{student}/grade-certificate', [\App\Http\Controllers\Admin\StudentManagementController::class, 'gradeCertificate'])->name('sias.admin.students.grade-certificate');
    Route::get('/students/{student}/edit', [\App\Http\Controllers\Admin\StudentManagementController::class, 'edit'])->name('sias.admin.students.edit');
    Route::put('/students/{student}', [\App\Http\Controllers\Admin\StudentManagementController::class, 'update'])->name('sias.admin.students.update');
    Route::delete('/students/{student}', [\App\Http\Controllers\Admin\StudentManagementController::class, 'destroy'])->name('sias.admin.students.destroy');

    // Course Management Routes
    Route::get('/course', [\App\Http\Controllers\Admin\CourseManagementController::class, 'index'])->name('sias.admin.course');
    Route::get('/course/course', [\App\Http\Controllers\Admin\CourseManagementController::class, 'courseList'])->name('sias.admin.course.list');
    Route::get('/course/add', [\App\Http\Controllers\Admin\CourseManagementController::class, 'create'])->name('sias.admin.course.add');
    Route::post('/course', [\App\Http\Controllers\Admin\CourseManagementController::class, 'store'])->name('sias.admin.course.store');
    Route::get('/course/{course}/edit', [\App\Http\Controllers\Admin\CourseManagementController::class, 'edit'])->name('sias.admin.course.edit');
    Route::put('/course/{course}', [\App\Http\Controllers\Admin\CourseManagementController::class, 'update'])->name('sias.admin.course.update');
    Route::delete('/course/{course}', [\App\Http\Controllers\Admin\CourseManagementController::class, 'destroy'])->name('sias.admin.course.delete');
    
    // Subject Management Routes
    Route::get('/subject', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'indexSias'])->name('sias.admin.subject');
    Route::get('/subject/add', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'createSias'])->name('sias.admin.subject.add');
    Route::post('/subject', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'storeSias'])->name('sias.admin.subject.store');
    Route::get('/subject/{subject}/edit', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'editSias'])->name('sias.admin.subject.edit');
    Route::put('/subject/{subject}', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'updateSias'])->name('sias.admin.subject.update');
    Route::delete('/subject/{subject}', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'destroySias'])->name('sias.admin.subject.delete');
    Route::post('/subject/{subject}/assign-teacher', [\App\Http\Controllers\Admin\SubjectManagementController::class, 'assignTeacherSias'])->name('sias.admin.subject.assign-teacher');
    Route::get('/enrollments', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'index'])->name('sias.admin.enrollments');
    Route::get('/enrollment', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'index'])->name('sias.admin.enrollment');
    Route::get('/enrollment/add', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'create'])->name('sias.admin.enrollment.add');
    Route::post('/enrollment', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'store'])->name('sias.admin.enrollment.store');
    Route::get('/enrollment/{id}/edit', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'edit'])->name('sias.admin.enrollment.edit');
    Route::put('/enrollment/{id}', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'update'])->name('sias.admin.enrollment.update');
    Route::delete('/enrollment/{id}', [\App\Http\Controllers\Admin\EnrollmentManagementController::class, 'destroy'])->name('sias.admin.enrollment.delete');
    Route::get('/announcements', function () {
        return view('sias.admin.announcements.index');
    })->name('sias.admin.announcements');
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportsController::class, 'siaSIndex'])->name('sias.admin.reports');
    Route::get('/module/{module}', function (string $module) {
        if ($module === 'audit-logs') {
            return redirect()->route('sias.admin.audit-logs');
        }

        $views = [
            'dashboard' => 'sias.admin.dashboard.index',
            'user-management' => 'sias.admin.user-management.index',
            'student-management' => 'sias.admin.student-management.index',
            'teacher-management' => 'sias.admin.teacher-management.index',
            'enrollment' => 'sias.admin.enrollment.index',
            'courses' => 'sias.admin.courses.index',
            'subjects' => 'sias.admin.subjects.index',
            'academic-management' => 'sias.admin.academic-management.index',
            'learning-management' => 'sias.admin.learning-management.index',
            'reports' => 'sias.admin.reports.index',
            'announcements' => 'sias.admin.announcements.index',
            'notifications' => 'sias.admin.notifications.index',
            'admin-staff-management' => 'sias.admin.admin-staff-management.index',
            'system-settings' => 'sias.admin.system-settings.index',
        ];

        abort_unless(isset($views[$module]), 404);

        return view($views[$module]);
    })->where('module', '[a-z0-9-]+')->name('sias.admin.module');
    Route::get('/audit-logs', [\App\Http\Controllers\Admin\SystemLogController::class, 'index'])->name('sias.admin.audit-logs');
    Route::get('/settings/{section}', [\App\Http\Controllers\Admin\SettingsController::class, 'section'])
        ->where('section', 'school-information|academic-settings|grading-settings|language|maintenance')
        ->name('sias.admin.settings.section');
    Route::put('/settings/{section}', [\App\Http\Controllers\Admin\SettingsController::class, 'updateSection'])
        ->where('section', 'school-information|academic-settings|grading-settings|language|maintenance')
        ->name('sias.admin.settings.section.update');
    Route::get('/settings/backup-restore', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('sias.admin.backup-restore');
    Route::post('/settings/backup-restore/whole-system', [\App\Http\Controllers\Admin\BackupController::class, 'fullBackup'])->name('sias.admin.backup.whole-system');
    Route::post('/settings/backup-restore/upload', [\App\Http\Controllers\Admin\BackupController::class, 'upload'])->name('sias.admin.backup.upload');
    Route::get('/settings', function () {
        return redirect()->route('sias.admin.settings.section', ['section' => 'school-information']);
    })->name('sias.admin.settings');
    Route::view('/account', 'sias.admin.account.index')->name('sias.admin.account');
    Route::view('/account/password', 'sias.admin.account.password')->name('sias.admin.account.password');
});

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
Route::get('/grades', [\App\Http\Controllers\StudentGradeController::class, 'index'])->name('grades')->middleware('auth');

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
    Route::get('/settings', [\App\Http\Controllers\UserSettingsController::class, 'index'])->name('user.settings');
    Route::post('/settings', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('user.settings.update');
    Route::get('/account/password', [AccountController::class, 'showPasswordForm'])->name('account.password.show');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    // Ajax endpoint for live course progress stats
    Route::get('/profile/enrollments/stats', [ProfileController::class, 'enrollmentStats'])
        ->name('userpage.enrollments.stats');
    Route::put('/profile', [ProfileController::class, 'update'])->name('userpage.profile-update');
    Route::redirect('/dashboard', '/my-learning')->name('userpage.dashboard');
    Route::redirect('/userpage/home', '/my-learning')->name('userpage.home');
    
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
    Route::get('/admin/users/create', [UserManagementController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [UserManagementController::class, 'storeUser'])->name('admin.users.store');
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

    // Legacy route alias for old syllabus routes (no prefix) – redirects to staff-prefixed routes
Route::get('syllabi', function () {
    return redirect()->route('staff.syllabi.index');
})->middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->name('syllabi.index');

Route::get('syllabi/{syllabus}/edit', function ($syllabus) {
    return redirect()->route('staff.syllabi.edit', $syllabus);
})->middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->name('syllabi.edit');

Route::post('syllabi/{syllabus}/publish', function ($syllabus) {
    return redirect()->route('staff.syllabi.publish', $syllabus);
})->middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->name('syllabi.publish');

Route::delete('syllabi/{syllabus}', function ($syllabus) {
    return redirect()->route('staff.syllabi.destroy', $syllabus);
})->middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->name('syllabi.destroy');

    // Dedicated staff routes (staff-facing UI)
    Route::middleware(['auth', \App\Http\Middleware\EnsureStaff::class])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\StaffFeatureController::class, 'dashboard'])->name('dashboard');

        // News/Announcements (staff)
        Route::get('/news', [\App\Http\Controllers\staff\NewsController::class, 'index'])->name('news.index');
        Route::post('/news', [\App\Http\Controllers\staff\NewsController::class, 'store'])->name('news.store');
        Route::put('/news/{id}', [\App\Http\Controllers\staff\NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{id}', [\App\Http\Controllers\staff\NewsController::class, 'destroy'])->name('news.destroy');

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
        Route::get('/competency-status', [\App\Http\Controllers\staff\ModuleController::class, 'competencyStatus'])->name('competency.index');
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
        Route::get('/assessments/schedule', [\App\Http\Controllers\staff\QuizController::class, 'schedule'])->name('assessments.schedule');
        Route::get('/assessments/results', [\App\Http\Controllers\staff\QuizController::class, 'results'])->name('assessments.results');
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

        // Trainer-to-subject assignments
        Route::resource('teacher-subjects', \App\Http\Controllers\staff\TeacherSubjectController::class)
            ->parameters(['teacher-subjects' => 'subject'])
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

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
        Route::resource('syllabi', \App\Http\Controllers\Staff\SyllabusController::class);
        Route::post('syllabi/{syllabus}/publish', [\App\Http\Controllers\Staff\SyllabusController::class, 'publish'])->name('syllabi.publish');
        Route::resource('subjects', \App\Http\Controllers\Staff\SubjectController::class);
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
        Route::get('/schedule/create', [\App\Http\Controllers\StaffFeatureController::class, 'createSchedule'])->name('schedule.create');
        Route::post('/schedule', [\App\Http\Controllers\StaffFeatureController::class, 'storeSchedule'])->name('schedule.store');
        Route::get('/schedule/{schedule}/edit', [\App\Http\Controllers\StaffFeatureController::class, 'editSchedule'])->name('schedule.edit');
        Route::put('/schedule/{schedule}', [\App\Http\Controllers\StaffFeatureController::class, 'updateSchedule'])->name('schedule.update');
        Route::delete('/schedule/{schedule}', [\App\Http\Controllers\StaffFeatureController::class, 'destroySchedule'])->name('schedule.destroy');
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
    Route::post('/admin/users/{user}/archive', [UserManagementController::class, 'deleteUser'])->name('admin.users.archive');
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

    // Major/Program management for admins
    Route::middleware([\App\Http\Middleware\EnsureAdmin::class])->group(function () {
        Route::get('/admin/majors', [App\Http\Controllers\MajorController::class, 'index'])->name('admin.majors.index');
        Route::get('/admin/majors/create', [App\Http\Controllers\MajorController::class, 'create'])->name('admin.majors.create');
        Route::post('/admin/majors', [App\Http\Controllers\MajorController::class, 'store'])->name('admin.majors.store');
        Route::get('/admin/majors/{major}', [App\Http\Controllers\MajorController::class, 'show'])->name('admin.majors.show');
        Route::get('/admin/majors/{major}/edit', [App\Http\Controllers\MajorController::class, 'edit'])->name('admin.majors.edit');
        Route::put('/admin/majors/{major}', [App\Http\Controllers\MajorController::class, 'update'])->name('admin.majors.update');
        Route::delete('/admin/majors/{major}', [App\Http\Controllers\MajorController::class, 'destroy'])->name('admin.majors.destroy');
        Route::post('/admin/majors/{major}/assign-course', [App\Http\Controllers\MajorController::class, 'assignCourse'])->name('admin.majors.assign-course');
        Route::delete('/admin/majors/{major}/courses/{course}', [App\Http\Controllers\MajorController::class, 'removeCourse'])->name('admin.majors.remove-course');
        Route::post('/admin/majors/{major}/courses/{course}/set-primary', [App\Http\Controllers\MajorController::class, 'setPrimary'])->name('admin.majors.set-primary');
        Route::get('/admin/majors/{major}/available-courses', [App\Http\Controllers\MajorController::class, 'getAvailableCourses'])->name('admin.majors.available-courses');
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

    Route::middleware([\App\Http\Middleware\EnsureAdmin::class])->group(function () {
        Route::get('/admin/students', [StudentManagementController::class, 'index'])->name('admin.students.index');
        Route::get('/admin/students/{student}', [StudentManagementController::class, 'show'])->name('admin.students.show');
        Route::get('/admin/students/create', [StudentManagementController::class, 'create'])->name('admin.students.create');
        Route::post('/admin/students', [StudentManagementController::class, 'store'])->name('admin.students.store');
        Route::get('/admin/students/{student}/edit', [StudentManagementController::class, 'edit'])->name('admin.students.edit');
        Route::put('/admin/students/{student}', [StudentManagementController::class, 'update'])->name('admin.students.update');
        Route::delete('/admin/students/{student}', [StudentManagementController::class, 'destroy'])->name('admin.students.destroy');

        Route::get('/admin/subjects', [SubjectManagementController::class, 'index'])->name('admin.subjects.index');
        Route::get('/admin/subjects/create', [SubjectManagementController::class, 'create'])->name('admin.subjects.create');
        Route::post('/admin/subjects', [SubjectManagementController::class, 'store'])->name('admin.subjects.store');
        Route::get('/admin/subjects/{subject}/edit', [SubjectManagementController::class, 'edit'])->name('admin.subjects.edit');
        Route::put('/admin/subjects/{subject}', [SubjectManagementController::class, 'update'])->name('admin.subjects.update');
        Route::delete('/admin/subjects/{subject}', [SubjectManagementController::class, 'destroy'])->name('admin.subjects.destroy');
        Route::post('/admin/subjects/{subject}/assign-teacher', [SubjectManagementController::class, 'assignTeacher'])->name('admin.subjects.assign-teacher');

        Route::get('/admin/sections', [SectionManagementController::class, 'index'])->name('admin.sections.index');
        Route::get('/admin/sections/create', [SectionManagementController::class, 'create'])->name('admin.sections.create');
        Route::post('/admin/sections', [SectionManagementController::class, 'store'])->name('admin.sections.store');
        Route::get('/admin/sections/{section}/edit', [SectionManagementController::class, 'edit'])->name('admin.sections.edit');
        Route::put('/admin/sections/{section}', [SectionManagementController::class, 'update'])->name('admin.sections.update');
        Route::delete('/admin/sections/{section}', [SectionManagementController::class, 'destroy'])->name('admin.sections.destroy');

        Route::get('/admin/schedules', [ScheduleManagementController::class, 'index'])->name('admin.schedules.index');
        Route::get('/admin/schedules/create', [ScheduleManagementController::class, 'create'])->name('admin.schedules.create');
        Route::post('/admin/schedules', [ScheduleManagementController::class, 'store'])->name('admin.schedules.store');
        Route::get('/admin/schedules/{schedule}/edit', [ScheduleManagementController::class, 'edit'])->name('admin.schedules.edit');
        Route::put('/admin/schedules/{schedule}', [ScheduleManagementController::class, 'update'])->name('admin.schedules.update');
        Route::delete('/admin/schedules/{schedule}', [ScheduleManagementController::class, 'destroy'])->name('admin.schedules.destroy');

        Route::get('/admin/attendance', [AttendanceMonitoringController::class, 'index'])->name('admin.attendance.index');
        Route::get('/admin/attendance/create', [AttendanceMonitoringController::class, 'create'])->name('admin.attendance.create');
        Route::post('/admin/attendance', [AttendanceMonitoringController::class, 'store'])->name('admin.attendance.store');
        Route::get('/admin/attendance/{attendance}/edit', [AttendanceMonitoringController::class, 'edit'])->name('admin.attendance.edit');
        Route::put('/admin/attendance/{attendance}', [AttendanceMonitoringController::class, 'update'])->name('admin.attendance.update');
        Route::delete('/admin/attendance/{attendance}', [AttendanceMonitoringController::class, 'destroy'])->name('admin.attendance.destroy');

        Route::get('/admin/grades', [GradeManagementController::class, 'index'])->name('admin.grades.index');
        Route::get('/admin/grades/create', [GradeManagementController::class, 'create'])->name('admin.grades.create');
        Route::post('/admin/grades', [GradeManagementController::class, 'store'])->name('admin.grades.store');
        Route::get('/admin/grades/{grade}/edit', [GradeManagementController::class, 'edit'])->name('admin.grades.edit');
        Route::put('/admin/grades/{grade}', [GradeManagementController::class, 'update'])->name('admin.grades.update');
        Route::delete('/admin/grades/{grade}', [GradeManagementController::class, 'destroy'])->name('admin.grades.destroy');

        Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
        Route::get('/admin/announcements/create', [AnnouncementController::class, 'create'])->name('admin.announcements.create');
        Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
        Route::get('/admin/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
        Route::put('/admin/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
        Route::delete('/admin/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');
    });

    Route::middleware([\App\Http\Middleware\EnsureAdmin::class])->group(function () {
        Route::post('/admin/enrollments/{enrollment}/approve', [App\Http\Controllers\Admin\EnrollmentController::class, 'approve'])->name('admin.enrollments.approve');
    });

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

    // Admin News Routes
    Route::get('/admin/news', [App\Http\Controllers\NewsController::class, 'adminIndex'])->name('admin.news.index');
    Route::get('/admin/news/create', [App\Http\Controllers\NewsController::class, 'adminCreate'])->name('admin.news.create');
    Route::post('/admin/news', [App\Http\Controllers\NewsController::class, 'adminStore'])->name('admin.news.store');
    Route::get('/admin/news/view', [App\Http\Controllers\NewsController::class, 'adminIndex'])->name('admin.news.view');
    Route::get('/admin/news/{id}', [App\Http\Controllers\NewsController::class, 'adminShow'])->name('admin.news.show');
    Route::get('/admin/news/{id}/edit', [App\Http\Controllers\NewsController::class, 'adminEdit'])->name('admin.news.edit');
    Route::put('/admin/news/{id}', [App\Http\Controllers\NewsController::class, 'adminUpdate'])->name('admin.news.update');
    Route::delete('/admin/news/{id}', [App\Http\Controllers\NewsController::class, 'adminDestroy'])->name('admin.news.destroy');

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
    Route::post('/admin/backup/upload', [\App\Http\Controllers\Admin\BackupController::class, 'upload'])->name('admin.backup.upload');
    Route::get('/admin/backup/download/{file}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('admin.backup.download');
    Route::post('/admin/backup/restore', [App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('admin.backup.restore');
    Route::delete('/admin/backup/{backup}', [\App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('admin.backup.delete');

});

        // (legacy simple staff routes removed — dedicated staff routes exist above)