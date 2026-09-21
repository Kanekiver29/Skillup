<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\ClassSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class StaffFeatureController extends Controller
{
    public function dashboard()
    {
        return view('staff.dashboard');
    }

    public function users()
    {
        $this->authorizeStaff();

        $q = request()->query('q');
        $role = request()->query('role');

        $query = User::query();
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%");
            });
        }
        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('name')->paginate(25)->withQueryString();
        $roles = ['admin' => 'Admin', 'staff' => 'Staff', 'teacher' => 'Trainer', 'assessor' => 'Assessor', 'registrar' => 'Registrar', 'trainee' => 'Trainee'];

        return view('staff.users.index', compact('users', 'roles', 'q', 'role'));
    }

    public function createUser()
    {
        $this->authorizeStaff();
        $roles = ['staff','teacher','assessor','registrar','trainee','admin'];
        $courses = Course::orderBy('title')->get(['id', 'title']);
        return view('staff.users.create', compact('roles', 'courses'));
    }

    public function storeUser(Request $request)
    {
        $this->authorizeStaff();
        $this->authorize('manageUsers', User::class);
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email',
            'username' => 'nullable|string|max:100|unique:users,username',
            'role' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'department' => 'nullable|string|max:191',
            'assigned_course_id' => 'nullable|integer|exists:courses,id',
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'] ?? null;
        $user->role = $data['role'];
        if (!empty($data['password'])) $user->password = \Illuminate\Support\Facades\Hash::make($data['password']);
        else $user->password = \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12));
        $user->department = $data['department'] ?? null;
        $user->assigned_course_id = $data['assigned_course_id'] ?? null;
        $user->save();

        // Notify user by email when mail is configured
        try {
            Mail::to($user->email)->send(new AccountCreated($user, $plain));
        } catch (\Exception $e) {
            // fail silently for dev environments
        }

        return redirect()->route('staff.users.index')->with('success', 'User created.');
    }

    public function editUser(User $user)
    {
        $this->authorizeStaff();
        $roles = ['staff','teacher','assessor','registrar','trainee','admin'];
        $courses = Course::orderBy('title')->get(['id', 'title']);
        return view('staff.users.edit', compact('user', 'roles', 'courses'));
    }

    public function updateUser(Request $request, User $user)
    {
        $this->authorizeStaff();
        $this->authorize('manageUsers', User::class);
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:100|unique:users,username,' . $user->id,
            'role' => 'required|string',
            'department' => 'nullable|string|max:191',
            'assigned_course_id' => 'nullable|integer|exists:courses,id',
        ]);
        $user->fill($data);
        $user->department = $data['department'] ?? null;
        $user->assigned_course_id = $data['assigned_course_id'] ?? null;
        $user->save();
        return redirect()->route('staff.users.index')->with('success', 'User updated.');
    }

    public function resetUserPassword(Request $request, User $user)
    {
        $this->authorizeStaff();
        $this->authorize('manageUsers', User::class);
        $new = Str::random(12);
        $user->password = \Illuminate\Support\Facades\Hash::make($new);
        $user->save();
        // send password reset notification
        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $new));
        } catch (\Exception $e) {
            // ignore mail exceptions in dev
        }

        return redirect()->route('staff.users.edit', $user)->with('success', 'Password reset. New password: ' . $new);
    }

    public function toggleUserStatus(Request $request, User $user)
    {
        $this->authorizeStaff();
        // simple status toggle: active/inactive using 'is_active' boolean
        if (Schema::hasColumn('users', 'is_active')) {
            $user->is_active = ! (bool) $user->is_active;
            $user->save();
        }
        return redirect()->route('staff.users.index')->with('success', 'User status updated.');
    }

    public function enrollments()
    {
        $this->authorizeStaff();

        $request = request();

        $query = Enrollment::with(['user', 'course']);

        // Search by student name/email or course title
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('course', function ($cq) use ($search) {
                    $cq->where('title', 'like', "%{$search}%")
                       ->orWhere('course_title', 'like', "%{$search}%");
                });
            });
        }

        if ($courseId = $request->query('course')) {
            $query->where('course_id', $courseId);
        }

        if ($status = $request->query('status')) {
            if (Schema::hasColumn('enrollments', 'status')) {
                $query->where('status', $status);
            } else {
                // Fallback to completed flag for basic states
                if ($status === 'active') $query->where('completed', false);
                if ($status === 'complete' || $status === 'completed') $query->where('completed', true);
            }
        }

        if ($year = $request->query('year_level')) {
            if (Schema::hasColumn('enrollments', 'year_level')) {
                $query->where('year_level', $year);
            }
        }

        $enrollments = $query->latest()->paginate(25)->withQueryString();

        // Attach convenient `student` and `course->name` attributes expected by the view
        foreach ($enrollments as $e) {
            $e->student = $e->user;
            if ($e->course) {
                $e->course->name = $e->course->course_title ?? $e->course->title ?? ($e->course->attributes['title'] ?? null);
                $e->course->code = $e->course->code ?? $e->course->slug ?? '';
            }
        }

        // Select a friendly `name` alias for legacy views (use `title` column)
        $courses = Course::orderBy('title')->get(['id', 'title as name']);
        // Use `lrn` as the student identifier if `student_id` column doesn't exist
        $students = User::where('is_admin', false)
            ->orderBy('name')
            ->get(['id', 'name', 'lrn as student_id']);

        $stats = ['total' => Enrollment::count(), 'active' => 0, 'pending' => 0, 'dropped' => 0];
        if (Schema::hasColumn('enrollments', 'status')) {
            $stats['active'] = Enrollment::where('status', 'active')->count();
            $stats['pending'] = Enrollment::where('status', 'pending')->count();
            $stats['dropped'] = Enrollment::where('status', 'dropped')->count();
        } else {
            $stats['active'] = Enrollment::where('completed', false)->count();
            $stats['pending'] = 0;
            $stats['dropped'] = Enrollment::where('completed', true)->count();
        }

        return view('staff.enrollments.index', compact('enrollments', 'courses', 'students', 'stats'));
    }

    public function dailyReports()
    {
        $this->authorizeStaff();

        $today = Carbon::today();
        $daily = [];

        // Attendance: present / absent
        if (Schema::hasTable('attendances')) {
            $daily['present'] = DB::table('attendances')->whereDate('attended_at', $today)->where('present', 1)->count();
            $daily['absent'] = DB::table('attendances')->whereDate('attended_at', $today)->where('present', 0)->count();
        } else {
            // fallback to session demo data
            $att = session('staff_daily_attendance', ['present' => 0, 'absent' => 0]);
            $daily['present'] = $att['present'] ?? 0;
            $daily['absent'] = $att['absent'] ?? 0;
        }

        // New trainee registrations today
        if (Schema::hasTable('users')) {
            $daily['new_registrations'] = User::whereDate('created_at', $today)->where('is_admin', false)->count();
        } else {
            $daily['new_registrations'] = session('staff_daily_new_regs', 0);
        }

        // Trainee concerns/issues (session backed when table missing)
        if (Schema::hasTable('trainee_concerns')) {
            $daily['concerns'] = DB::table('trainee_concerns')->whereDate('created_at', $today)->get();
        } else {
            $daily['concerns'] = collect(session('staff_daily_concerns', []));
        }

        // Training activities: classes, hours, modules, practicals
        if (Schema::hasTable('training_sessions')) {
            $daily['classes_conducted'] = DB::table('training_sessions')->whereDate('started_at', $today)->count();
            $daily['training_hours'] = DB::table('training_sessions')->whereDate('started_at', $today)->sum(DB::raw('TIMESTAMPDIFF(MINUTE, started_at, ended_at)')) / 60;
            $daily['modules_discussed'] = DB::table('training_sessions')->whereDate('started_at', $today)->pluck('module')->unique()->values();
            $daily['practical_completed'] = DB::table('training_sessions')->whereDate('started_at', $today)->where('practical_done', 1)->count();
        } else {
            $daily['classes_conducted'] = session('staff_daily_classes', 0);
            $daily['training_hours'] = session('staff_daily_hours', 0);
            $daily['modules_discussed'] = collect(session('staff_daily_modules', []));
            $daily['practical_completed'] = session('staff_daily_practicals', 0);
        }

        // Assessments (defensive: check table and columns)
        if (Schema::hasTable('assessments')) {
            if (Schema::hasColumn('assessments', 'conducted_at')) {
                $daily['assessments_conducted'] = DB::table('assessments')->whereDate('conducted_at', $today)->count();
            } elseif (Schema::hasColumn('assessments', 'created_at')) {
                $daily['assessments_conducted'] = DB::table('assessments')->whereDate('created_at', $today)->count();
            } else {
                $daily['assessments_conducted'] = 0;
            }

            if (Schema::hasTable('assessment_results')) {
                $dateCol = Schema::hasColumn('assessment_results', 'created_at') ? 'created_at' : (Schema::hasColumn('assessment_results', 'recorded_at') ? 'recorded_at' : null);
                if ($dateCol) {
                    $daily['trainees_assessed'] = DB::table('assessment_results')->whereDate($dateCol, $today)->distinct('user_id')->count('user_id');
                    $daily['assessment_results'] = DB::table('assessment_results')->whereDate($dateCol, $today)->selectRaw('SUM(CASE WHEN passed=1 THEN 1 ELSE 0 END) as passed, SUM(CASE WHEN passed=0 THEN 1 ELSE 0 END) as failed')->first();
                } else {
                    $daily['trainees_assessed'] = 0;
                    $daily['assessment_results'] = (object)['passed' => 0, 'failed' => 0];
                }
            } else {
                $daily['trainees_assessed'] = session('staff_daily_trainees_assessed', 0);
                $daily['assessment_results'] = (object)['passed' => 0, 'failed' => 0];
            }
        } else {
            $daily['assessments_conducted'] = session('staff_daily_assessments', 0);
            $daily['trainees_assessed'] = session('staff_daily_trainees_assessed', 0);
            $daily['assessment_results'] = (object)['passed' => 0, 'failed' => 0];
        }

        // Certificates
        if (Schema::hasTable('certificates')) {
            $daily['certificates_processed'] = DB::table('certificates')->whereDate('processed_at', $today)->count();
            $daily['certificates_released'] = DB::table('certificates')->whereDate('released_at', $today)->count();
            $daily['certificates_pending'] = DB::table('certificates')->where('status', 'pending')->count();
        } else {
            $daily['certificates_processed'] = session('staff_daily_certs_processed', 0);
            $daily['certificates_released'] = session('staff_daily_certs_released', 0);
            $daily['certificates_pending'] = session('staff_daily_certs_pending', 0);
        }

        // Trainer activities
        if (Schema::hasTable('users')) {
            $teacherQuery = DB::table('users')->where('role', 'teacher');

            if (Schema::hasColumn('users', 'last_seen_at')) {
                $teacherQuery = $teacherQuery->whereDate('last_seen_at', $today);
            } elseif (Schema::hasColumn('users', 'last_login_at')) {
                $teacherQuery = $teacherQuery->whereDate('last_login_at', $today);
            } elseif (Schema::hasColumn('users', 'updated_at')) {
                $teacherQuery = $teacherQuery->whereDate('updated_at', $today);
            } // otherwise no date filter available

            $daily['trainers_present'] = $teacherQuery->count();
            $daily['trainer_schedules'] = collect();
            $daily['trainer_notes'] = collect();
        } else {
            $daily['trainers_present'] = session('staff_daily_trainers_present', 0);
            $daily['trainer_schedules'] = collect(session('staff_daily_trainer_schedules', []));
            $daily['trainer_notes'] = collect(session('staff_daily_trainer_notes', []));
        }

        // Administrative tasks & issues
        $daily['documents_processed'] = session('staff_daily_docs_processed', 0);
        $daily['reports_submitted'] = session('staff_daily_reports_submitted', 0);
        $daily['meetings_attended'] = session('staff_daily_meetings', 0);
        $daily['inventory_updates'] = session('staff_daily_inventory', 0);
        $daily['issues'] = collect(session('staff_daily_issues', []));

        // Daily summary
        $daily['total_present'] = $daily['present'];
        $daily['total_activities'] = ($daily['classes_conducted'] ?? 0) + ($daily['assessments_conducted'] ?? 0) + ($daily['documents_processed'] ?? 0);
        $daily['accomplishments'] = session('staff_daily_accomplishments', []);
        $daily['recommendations'] = session('staff_daily_recommendations', []);

        return view('staff.reports.daily', compact('daily'));
    }

    public function staffReports()
    {
        $this->authorizeStaff();

        $reports = [];

        try {
            // Enrollment reports
            $reports['total_enrollees'] = Schema::hasTable('enrollments') ? Enrollment::count() : 0;
            $reports['new_enrollees_30d'] = Schema::hasTable('enrollments') ? Enrollment::where('created_at', '>=', Carbon::now()->subDays(30))->count() : 0;

            if (Schema::hasTable('courses') && Schema::hasTable('enrollments')) {
                $reports['enrollment_by_course'] = Course::withCount('enrollments')->orderBy('enrollments_count', 'desc')->take(10)->get();
                $reports['enrollment_by_month'] = Enrollment::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, count(*) as total")->groupBy('month')->orderBy('month')->get();
            } else {
                $reports['enrollment_by_course'] = collect();
                $reports['enrollment_by_month'] = collect();
            }

            // Trainee reports
            if (Schema::hasTable('enrollments')) {
                if (Schema::hasColumn('enrollments', 'status')) {
                    $reports['active_trainees'] = Enrollment::where('status', 'active')->count();
                    $reports['completed_trainees'] = Enrollment::where('status', 'completed')->count();
                    $reports['dropped_trainees'] = Enrollment::where('status', 'dropped')->count();
                } else {
                    $reports['active_trainees'] = Enrollment::where('completed', false)->count();
                    $reports['completed_trainees'] = Enrollment::where('completed', true)->count();
                    $reports['dropped_trainees'] = 0;
                }
            }

            // Attendance (if table exists)
            if (Schema::hasTable('attendances')) {
                $reports['attendance_summary'] = DB::table('attendances')
                    ->selectRaw("DATE(attended_at) as date, SUM(CASE WHEN present = 1 THEN 1 ELSE 0 END) as present_count")
                    ->groupBy('date')->orderBy('date', 'desc')->limit(30)->get();
            } else {
                $reports['attendance_summary'] = collect();
            }

            // Assessment reports (best-effort)
            if (class_exists(\App\Models\Assessment::class) && Schema::hasTable('assessments')) {
                $reports['assessments_total'] = \App\Models\Assessment::count();
            } else {
                $reports['assessments_total'] = 0;
            }

            // Certificates
            if (Schema::hasTable('certificates')) {
                $reports['certificates_issued'] = DB::table('certificates')->where('status', 'issued')->count();
                $reports['certificates_pending'] = DB::table('certificates')->where('status', 'pending')->count();
            } else {
                $reports['certificates_issued'] = 0;
                $reports['certificates_pending'] = 0;
            }

            // Trainer reports
            $reports['trainers_count'] = Schema::hasTable('users') ? User::where('role', 'teacher')->count() : 0;

            // Course reports: completion rates per course
            if (Schema::hasTable('courses') && Schema::hasTable('enrollments')) {
                $reports['course_completion'] = DB::table('courses')
                    ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
                    ->selectRaw('courses.id, courses.title, SUM(CASE WHEN enrollments.completed = 1 THEN 1 ELSE 0 END) as completed_count, COUNT(enrollments.id) as total_enrolled')
                    ->groupBy('courses.id', 'courses.title')
                    ->orderByRaw('completed_count / NULLIF(total_enrolled, 0) DESC')
                    ->limit(10)
                    ->get();
            } else {
                $reports['course_completion'] = collect();
            }

            // Financial (payments) if present
            if (Schema::hasTable('payments')) {
                $reports['total_fees_collected'] = DB::table('payments')->sum('amount');
            } else {
                $reports['total_fees_collected'] = 0;
            }

            // System reports (activity/login)
            if (Schema::hasTable('login_histories')) {
                $reports['login_history_count'] = DB::table('login_histories')->count();
            } else {
                $reports['login_history_count'] = 0;
            }

        } catch (\Exception $e) {
            // Fail gracefully and provide empty/default values
            $reports = $reports + [
                'total_enrollees' => $reports['total_enrollees'] ?? 0,
            ];
        }

        return view('staff.reports.staff', compact('reports'));
    }

    public function settings()
    {
        if (! auth()->check() || ! auth()->user()->hasStaffAccess()) {
            abort(403, 'Forbidden');
        }

        $settings = [
            'app_name'         => config('app.name'),
            'app_env'          => config('app.env'),
            'app_debug'        => config('app.debug'),
            'app_url'          => config('app.url'),
            'cache_driver'     => config('cache.default'),
            'session_driver'   => config('session.driver'),
            'session_lifetime' => config('session.lifetime'),
            'queue_connection' => config('queue.default'),
            'filesystems'      => config('filesystems.default'),
        ];

        return view('staff.settings.index', compact('settings'));
    }

    public function courseRecords()
    {
        return view('staff.course_records.index');
    }

    /**
     * Update basic profile (staff-facing).
     */
    public function updateProfile(Request $request)
    {
        $this->authorizeStaff();
        $user = $request->user();
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
        ]);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();
        return redirect()->route('staff.settings.index')->with('success', 'Profile updated.');
    }

    /**
     * Change password for current user.
     */
    public function changePassword(Request $request)
    {
        $this->authorizeStaff();
        $user = $request->user();
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            return redirect()->route('staff.settings.index')->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();
        return redirect()->route('staff.settings.index')->with('success', 'Password changed.');
    }

    /**
     * Upload profile picture (basic file handling, stores in storage/app/public/uploads).
     */
    public function uploadProfilePicture(Request $request)
    {
        $this->authorizeStaff();
        $user = $request->user();
        $data = $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $path = $request->file('avatar')->store('uploads/avatars', 'public');
        $user->profile_image = $path;
        $user->save();
        return redirect()->route('staff.settings.index')->with('success', 'Profile picture uploaded.');
    }

    public function updateAccountSettings(Request $request)
    {
        $this->authorizeStaff();
        // placeholder for account-level toggles (notifications, status)
        $data = $request->validate([
            'receive_notifications' => 'nullable|boolean',
            'account_status' => 'nullable|string',
        ]);
        // persist to session for now
        session(['staff_account_settings' => $data]);
        return redirect()->route('staff.settings.index')->with('success', 'Account settings saved (temporary).');
    }

    public function updateOrganization(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'org_name' => 'required|string|max:255',
            'org_address' => 'nullable|string|max:1000',
            'org_contact' => 'nullable|string|max:255',
        ]);
        session(['staff_org_info' => $data]);
        return redirect()->route('staff.settings.index')->with('success', 'Organization information saved (temporary).');
    }

    public function updateCourseSettings(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'default_category' => 'nullable|string|max:255',
            'certificate_required' => 'nullable|boolean',
        ]);
        session(['staff_course_settings' => $data]);
        return redirect()->route('staff.settings.index')->with('success', 'Course settings saved (temporary).');
    }

    public function updateCertificateSettings(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'certificate_prefix' => 'nullable|string|max:50',
            'signature_name' => 'nullable|string|max:255',
        ]);
        session(['staff_certificate_settings' => $data]);
        return redirect()->route('staff.settings.index')->with('success', 'Certificate settings saved (temporary).');
    }

    public function updateNotificationSettings(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean',
            'announcements_enabled' => 'nullable|boolean',
        ]);
        session(['staff_notification_settings' => $data]);
        return redirect()->route('staff.settings.index')->with('success', 'Notification settings saved (temporary).');
    }

    public function updateSecuritySettings(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'password_policy_min_length' => 'nullable|integer|min:6|max:128',
            'lockout_attempts' => 'nullable|integer|min:1|max:20',
        ]);
        session(['staff_security_settings' => $data]);
        return redirect()->route('staff.settings.index')->with('success', 'Security settings saved (temporary).');
    }

    public function activityLogs()
    {
        $this->authorizeStaff();
        $logs = session('staff_activity_logs', collect()->toArray());
        if (view()->exists('staff.settings.activity_logs')) {
            return view('staff.settings.activity_logs', compact('logs'));
        }
        return redirect()->route('staff.settings.index');
    }

    public function toggleClock(Request $request)
    {
        $this->authorizeStaff();

        $clocked = session('staff_clocked_in', false);
        if ($clocked) {
            session()->forget('staff_clocked_in');
            $msg = 'You have been clocked out.';
            $status = 'out';
        } else {
            session(['staff_clocked_in' => now()->toDateTimeString()]);
            $msg = 'You have been clocked in.';
            $status = 'in';
        }

        // If request expects JSON (AJAX), return JSON for a smoother UX.
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'ok',
                'message' => $msg,
                'clocked' => $status,
                'clocked_at' => session('staff_clocked_in', null),
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function indexTasks()
    {
        $this->authorizeStaff();

        $tasks = session('staff_tasks', []);
        return view('staff.tasks.index', compact('tasks'));
    }

    public function createTask()
    {
        $this->authorizeStaff();
        return view('staff.tasks.create');
    }

    public function storeTask(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'due' => 'nullable|string|max:255',
        ]);
        $data['created_at'] = now()->toDateTimeString();
        session()->push('staff_tasks', $data);
        return redirect()->route('staff.tasks.create')->with('success', 'Task created.');
    }

    public function showLeaveForm()
    {
        $this->authorizeStaff();
        return view('staff.leave.request');
    }

    public function submitLeaveRequest(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);
        $data['submitted_at'] = now()->toDateTimeString();
        session()->push('staff_leave_requests', $data);
        return redirect()->route('staff.leave.request')->with('success', 'Leave request submitted.');
    }

    public function attendance()
    {
        $this->authorizeStaff();

        $attendance = [
            'hours_logged' => 32.5,
            'target_hours' => 40,
            'days' => [
                ['label' => 'Mon', 'state' => 'active'],
                ['label' => 'Tue', 'state' => 'active'],
                ['label' => 'Wed', 'state' => 'active'],
                ['label' => 'Thu', 'state' => 'pending'],
                ['label' => 'Fri', 'state' => 'pending'],
            ],
        ];

        return view('staff.attendance.index', compact('attendance'));
    }

    public function schedule()
    {
        $this->authorizeStaff();

        if (!Schema::hasTable('class_schedules')) {
            $schedule = session('staff_schedule', [
                ['time' => '9:00 AM', 'event' => 'Shift starts'],
                ['time' => '12:00 PM', 'event' => 'Team standup meeting'],
                ['time' => '1:00 PM', 'event' => 'Lunch break'],
            ]);

            return view('staff.schedule.index', compact('schedule'));
        }

        $schedule = ClassSchedule::with(['teacher', 'course'])
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') ASC")
            ->orderBy('start_time')
            ->get()
            ->map(function ($entry) {
                $day = $entry->day_of_week ?? 'Schedule';
                $time = $entry->start_time && $entry->end_time
                    ? $entry->start_time . ' - ' . $entry->end_time
                    : ($entry->start_time ?? 'Time TBD');

                $teacherName = $entry->teacher?->name ?? 'Assigned trainer';
                $courseName = $entry->course?->title ?? $entry->subject_name ?? 'Class session';
                $room = $entry->room_number ? ' · Room ' . $entry->room_number : '';

                return [
                    'id' => $entry->id,
                    'time' => $day . ' · ' . $time,
                    'event' => $courseName . ' with ' . $teacherName . $room,
                ];
            })
            ->values()
            ->all();

        return view('staff.schedule.index', compact('schedule'));
    }

    public function createSchedule()
    {
        $this->authorizeStaff();

        $teachers = User::whereIn('role', ['teacher', 'staff'])->orderBy('name')->get(['id', 'name']);
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('staff.schedule.create', compact('teachers', 'courses'));
    }

    public function storeSchedule(Request $request)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
            'subject_name' => 'required|string|max:255',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'student_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data['is_active'] = true;
        ClassSchedule::create($data);

        return redirect()->route('staff.schedule.index')->with('success', 'Schedule added successfully.');
    }

    public function editSchedule(ClassSchedule $schedule)
    {
        $this->authorizeStaff();

        $teachers = User::whereIn('role', ['teacher', 'staff'])->orderBy('name')->get(['id', 'name']);
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('staff.schedule.edit', compact('schedule', 'teachers', 'courses'));
    }

    public function updateSchedule(Request $request, ClassSchedule $schedule)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
            'subject_name' => 'required|string|max:255',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'student_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $schedule->update($data);

        return redirect()->route('staff.schedule.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroySchedule(ClassSchedule $schedule)
    {
        $this->authorizeStaff();
        $schedule->delete();

        return redirect()->route('staff.schedule.index')->with('success', 'Schedule deleted successfully.');
    }

    public function contactSupport()
    {
        $this->authorizeStaff();
        return view('staff.support.index');
    }

    public function sendSupport(Request $request)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        $data['sent_at'] = now()->toDateTimeString();
        session()->push('staff_support_messages', $data);
        return redirect()->route('staff.support.index')->with('success', 'Support message sent.');
    }

    /**
     * Export enrollments as CSV for staff users.
     */
    public function exportEnrollments()
    {
        $this->authorizeStaff();

        $enrollments = \App\Models\Enrollment::with(['user', 'course'])->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="staff_enrollments_' . now()->format('Y-m-d') . '.csv"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        $callback = function () use ($enrollments) {
            $file = fopen('php://output', 'w');
            // BOM for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Name', 'Email', 'Course', 'Progress (%)', 'Status', 'Enrolled Date', 'Last Updated'
            ]);

            foreach ($enrollments as $enrollment) {
                $user = $enrollment->user;
                fputcsv($file, [
                    $user->name ?? 'Unknown',
                    $user->email ?? 'N/A',
                    $enrollment->course->course_title ?? 'Unknown',
                    round($enrollment->progress ?? 0, 2),
                    $enrollment->status ?? 'Pending',
                    $enrollment->created_at?->format('Y-m-d H:i') ?? 'N/A',
                    $enrollment->updated_at?->format('Y-m-d H:i') ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Store a new enrollment (basic implementation).
     */
    public function storeEnrollment(Request $request)
    {
        $this->authorizeStaff();

        $data = $request->validate([
            'student_id' => 'required|integer|exists:users,id',
            'course_id' => 'required|integer|exists:courses,id',
            'year_level' => 'nullable|integer|min:1|max:12',
            'section' => 'nullable|string|max:100',
            'enrolled_at' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $enrollment = new \App\Models\Enrollment();
        $enrollment->user_id = $data['student_id'];
        $enrollment->course_id = $data['course_id'];
        $enrollment->year_level = $data['year_level'] ?? null;
        $enrollment->section = $data['section'] ?? null;
        $enrollment->enrolled_at = $data['enrolled_at'] ? \Carbon\Carbon::parse($data['enrolled_at']) : now();
        $enrollment->status = $data['status'] ?? 'active';
        $enrollment->save();

        return redirect()->route('staff.enrollments.index')->with('success', 'Student enrolled successfully.');
    }

    public function showEnrollment(\App\Models\Enrollment $enrollment)
    {
        $this->authorizeStaff();
        if (view()->exists('staff.enrollments.show')) {
            return view('staff.enrollments.show', compact('enrollment'));
        }
        return redirect()->route('staff.enrollments.index');
    }

    public function editEnrollment(\App\Models\Enrollment $enrollment)
    {
        $this->authorizeStaff();
        if (view()->exists('staff.enrollments.edit')) {
            return view('staff.enrollments.edit', compact('enrollment'));
        }
        return redirect()->route('staff.enrollments.index');
    }

    public function updateEnrollment(Request $request, \App\Models\Enrollment $enrollment)
    {
        $this->authorizeStaff();
        $data = $request->validate([
            'year_level' => 'nullable|integer|min:1|max:12',
            'section' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'enrolled_at' => 'nullable|date',
        ]);
        $enrollment->fill($data);
        $enrollment->save();
        return redirect()->route('staff.enrollments.index')->with('success', 'Enrollment updated.');
    }

    public function destroyEnrollment(\App\Models\Enrollment $enrollment)
    {
        $this->authorizeStaff();
        $enrollment->delete();
        return redirect()->route('staff.enrollments.index')->with('success', 'Enrollment removed.');
    }

    /**
     * Dev helper: toggle the current user's staff role (local/debug only).
     * Use only in development to resolve access during testing.
     */
    public function toggleDebugStaff(Request $request)
    {
        if (!config('app.debug')) {
            abort(404);
        }
        $user = $request->user();
        if (!$user) {
            abort(403, 'Not authenticated');
        }
        if ($user->role === 'staff') {
            $user->role = 'user';
            $user->save();
            $msg = 'Demoted to regular user.';
        } else {
            $user->role = 'staff';
            $user->save();
            $msg = 'Promoted to staff.';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'ok', 'message' => $msg, 'role' => $user->role]);
        }
        return redirect()->back()->with('success', $msg);
    }

    /**
     * Dismiss a session-backed task by index. Supports AJAX.
     */
    public function dismissTask(Request $request, $index)
    {
        $this->authorizeStaff();
        $tasks = session('staff_tasks', []);
        if (!isset($tasks[$index])) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Task not found.'], 404);
            }
            return redirect()->back()->with('error', 'Task not found.');
        }

        // Remove the item and reindex
        array_splice($tasks, $index, 1);
        session(['staff_tasks' => array_values($tasks)]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'ok', 'message' => 'Task dismissed', 'index' => (int) $index]);
        }

        return redirect()->back()->with('success', 'Task dismissed.');
    }
}
