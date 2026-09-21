<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showPortalLogin(string $portal)
    {
        abort_unless(in_array($portal, ['sias-admin', 'course'], true), 404);

        return view('auth.portal-login', compact('portal'));
    }

    public function portalLogin(Request $request, string $portal)
    {
        abort_unless(in_array($portal, ['sias-admin', 'course'], true), 404);

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $request->boolean('remember'))) {
            return back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => 'The email or password is incorrect.',
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($portal === 'sias-admin') {
            if (! $user->isAdmin()) {
                Auth::logout();
                return back()->withInput($request->only('email', 'remember'))->withErrors([
                    'email' => 'This account does not have SIAS administrator access.',
                ]);
            }

            return redirect()->route('sias.admin.dashboard')->with('success', 'Welcome back to SIAS Administration.');
        }

        return redirect()->route($this->courseRedirectRoute($user))->with('success', 'Welcome back to SkillUp.');
    }

    protected function courseRedirectRoute(User $user): string
    {
        if ($user->isAdmin() || $user->hasStaffAccess()) {
            return $user->isTeacher() ? 'teacher.dashboard' : 'admin.dashboard';
        }

        return 'userpage.home';
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $identifier = $request->input('identifier', $request->input('email'));

        $validated = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required',
            'login_as' => 'required|in:admin,staff,teacher,student',
        ]);

        $loginAs = $validated['login_as'];

        if ($loginAs !== 'student') {
            $request->validate([
                'identifier' => 'required|email',
                'password' => 'required|min:6',
            ]);
        } else {
            $request->validate([
                'identifier' => 'required|string|min:3',
                'password' => 'required|min:4',
            ]);
        }

        $credentials = [
            'password' => $validated['password'],
        ];

        if ($loginAs === 'student') {
            $credentials['lrn'] = $validated['identifier'];
        } else {
            $credentials['email'] = $validated['identifier'];
        }

        // Attempt to authenticate
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $loginAs = $validated['login_as'];

            // Validate role matches the selected login type
            if ($loginAs === 'admin') {
                if (!$user->isAdmin()) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('identifier', 'login_as'))
                        ->withErrors(['login_as' => 'This account does not have Administrator access.']);
                }
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }

            if ($loginAs === 'teacher') {
                if (!method_exists($user, 'isTeacher') || !$user->isTeacher()) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('identifier', 'login_as'))
                        ->withErrors(['login_as' => 'This account is not registered as an Instructor.']);
                }

                return redirect()->route('teacher.dashboard')->with('success', 'Welcome back, Instructor!');
            }

            if ($loginAs === 'staff') {
                // Allow users with staff role or admin flag to sign in as staff
                if (!($user->role === 'staff' || $user->hasStaffAccess())) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('identifier', 'login_as'))
                        ->withErrors(['login_as' => 'This account is not registered as Staff.']);
                }

                return redirect()->route('staff.dashboard')->with('success', 'Welcome back, Staff!');
            }

            if ($loginAs === 'student') {
                if ($user->hasStaffAccess()) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('identifier', 'login_as'))
                        ->withErrors(['login_as' => 'Please use a student account or choose the correct role.']);
                }
                return redirect()->route('userpage.dashboard')->with('success', 'Login successful!');
            }
        }

        // Authentication failed
        return back()
            ->withInput($request->only('identifier', 'login_as'))
            ->withErrors([
                'identifier' => 'The provided credentials do not match our records.',
            ]);
    }

    /**
     * Show the register form.
     */
    public function showRegister()
    {
        $majors = \App\Models\Major::where('is_active', true)->orderBy('name')->get();

        return view('auth.register', compact('majors'));
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
            'age' => 'required|integer|min:1|max:120',
            'birthday' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'major_id' => 'nullable|exists:majors,id',
            'course_id' => 'nullable|exists:courses,id',
            'terms' => 'required|accepted',
        ]);

        $major = null;
        $course = null;

        if (!empty($validated['major_id'])) {
            $major = \App\Models\Major::findOrFail($validated['major_id']);

            $course = $major->courses()
                ->where('is_published', true)
                ->where('is_primary', true)
                ->first();

            if (!$course) {
                $course = $major->courses()
                    ->where('is_published', true)
                    ->first();
            }

            if (!$course) {
                return back()
                    ->withInput()
                    ->withErrors(['major_id' => 'The selected major does not have any available courses. Please contact support.']);
            }
        } elseif (!empty($validated['course_id'])) {
            $course = \App\Models\Course::where('id', $validated['course_id'])
                ->where('is_published', true)
                ->firstOrFail();
        } else {
            return back()
                ->withInput()
                ->withErrors(['major_id' => 'Please choose a major or course to continue.']);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'age' => $validated['age'],
            'birthday' => $validated['birthday'],
            'location' => $validated['address'],
            'role' => 'student',
            'major_id' => $major?->id,
            'assigned_course_id' => $course->id,
        ]);

        Enrollment::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'status' => 'approved',
                'progress' => 0,
                'completed' => false,
                'enrolled_at' => now(),
            ]
        );

        $subjects = $course->subjects()
            ->where('is_active', true)
            ->get();

        foreach ($subjects as $subject) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'subject_id' => $subject->id,
                ],
                [
                    'status' => 'approved',
                    'progress' => 0,
                    'completed' => false,
                    'enrolled_at' => now(),
                ]
            );
        }

        Auth::login($user);

        return redirect()->route('sias.student.registration')->with('success', 'Registration successful! You have been enrolled in ' . $course->title . ' with ' . $subjects->count() . ' subject(s).');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Handle SIAS student enrollment/login (Student ID + default password 0000)
     */
    public function siasLogin(Request $request)
    {
        $role = $request->input('login_as', 'student');

        if ($role === 'student') {
            $validated = $request->validate([
                'student_id' => 'required|string|min:3',
                'password' => 'required|min:4',
                'login_as' => 'required|in:student,teacher,admin',
            ]);

            $studentIdentifier = $validated['student_id'];
            $credentialsAttempts = [
                ['lrn' => $studentIdentifier, 'password' => $validated['password']],
                ['email' => $studentIdentifier, 'password' => $validated['password']],
            ];

            $authenticated = false;
            foreach ($credentialsAttempts as $credentials) {
                if (Auth::attempt($credentials)) {
                    $authenticated = true;
                    break;
                }
            }

            if ($authenticated) {
                $user = Auth::user();
                if ($user->hasStaffAccess()) {
                    Auth::logout();
                    return back()->withInput($request->only('student_id', 'login_as'))->withErrors([
                        'student_id' => 'This Student ID belongs to a staff or admin account.',
                    ]);
                }

                $request->session()->regenerate();

                $designatedCourse = $user->designatedCourse();
                if ($designatedCourse) {
                    return redirect()->route('courses.show', $designatedCourse->slug)
                        ->with('success', 'Login successful.');
                }

                return redirect()->route('sias.student.dashboard')->with('success', 'Login successful.');
            }

            return back()->withInput($request->only('student_id', 'login_as'))->withErrors([
                'student_id' => 'Invalid Student ID or password.',
            ]);
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'login_as' => 'required|in:student,teacher,admin',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (! Auth::attempt($credentials)) {
            return back()->withInput($request->only('email', 'login_as'))->withErrors([
                'email' => 'Invalid email or password.',
            ]);
        }

        $user = Auth::user();

        if ($role === 'admin' && ! $user->isAdmin()) {
            Auth::logout();
            return back()->withInput($request->only('email', 'login_as'))->withErrors([
                'login_as' => 'This account does not have admin access for SIAS.',
            ]);
        }

        if ($role === 'teacher' && ! $user->isTeacher()) {
            Auth::logout();
            return back()->withInput($request->only('email', 'login_as'))->withErrors([
                'login_as' => 'This account is not registered as a SIAS teacher.',
            ]);
        }

        $request->session()->regenerate();

        if ($role === 'admin') {
            return redirect()->route('sias.admin.dashboard')->with('success', 'Welcome back, SIAS Admin!');
        }

        return redirect()->route('sias.teacher.dashboard')->with('success', 'Welcome back, Teacher!');
    }

    public function enrollStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'lrn' => $validated['student_id'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('sias.student.dashboard')->with('success', 'Login successful.');
        }

        return back()->withErrors(['student_id' => 'Invalid Student ID or password.'])->withInput();
    }
}
