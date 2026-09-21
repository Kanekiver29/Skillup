<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherManagementController extends Controller
{
    protected function authorizeStaffAccess(): void
    {
        if (!auth()->check() || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeStaffAccess();

        $query = User::query()->where(function ($q) {
            $q->where('role', 'teacher')
              ->orWhere(function ($staffQuery) {
                  $staffQuery->where('role', 'staff')
                      ->whereIn('staff_type', ['teacher', 'instructor']);
              });
        })->withCount(['subjects', 'courses']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('staff_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $type = $request->type;
            if ($type === 'instructor') {
                $query->where('staff_type', 'instructor');
            } elseif ($type === 'teacher') {
                $query->where(function ($q) {
                    $q->where('role', 'teacher')
                      ->orWhere('staff_type', 'teacher');
                });
            }
        }

        $teachers = $query->latest()->paginate(15)->withQueryString();

        $students = User::where('role', 'student')
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        $stats = [
            'total' => User::where(function ($q) {
                $q->where('role', 'teacher')
                  ->orWhere(function ($staffQuery) {
                      $staffQuery->where('role', 'staff')
                          ->whereIn('staff_type', ['teacher', 'instructor']);
                  });
            })->count(),
            'instructors' => User::where(function($q) {
                $q->where('staff_type', 'instructor');
            })->count(),
            'teachers' => User::where(function ($q) {
                $q->where('role', 'teacher')
                  ->orWhere(function ($sq) {
                      $sq->where('role', 'staff')->where('staff_type', 'teacher');
                  });
            })->count(),
            'assigned_subjects' => Subject::whereNotNull('teacher_id')->count(),
        ];

        return view('Admin.teachers.index', compact('teachers', 'students', 'stats'));
    }

    public function store(Request $request)
    {
        $this->authorizeStaffAccess();

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'required_without:user_id|nullable|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);
            $user->update([
                'role' => 'teacher',
                'staff_type' => 'teacher',
            ]);

            return redirect()->route('admin.teachers.index')
                ->with('success', $user->name . ' has been promoted to Teacher.');
        }

        $user = User::create([
            'name' => $validated['name'] ?? 'New Teacher',
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'] ?? 'teacher1234'),
            'role' => 'teacher',
            'staff_type' => 'teacher',
            'is_admin' => false,
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', $user->name . ' has been created as Teacher.');
    }

    public function demote(User $user)
    {
        $this->authorizeStaffAccess();

        if ($user->role === 'teacher' || ($user->role === 'staff' && in_array($user->staff_type, ['teacher', 'instructor']))) {
            $user->update([
                'role' => 'student',
                'staff_type' => null,
            ]);

            return redirect()->route('admin.teachers.index')
                ->with('success', $user->name . ' has been removed from teacher management.');
        }

        return redirect()->route('admin.teachers.index')
            ->with('error', $user->name . ' is not currently assigned as a teacher.');
    }

    public function indexSias(Request $request)
    {
        $this->authorizeStaffAccess();

        $query = User::query()->where(function ($q) {
            $q->where('role', 'teacher')
              ->orWhere(function ($staffQuery) {
                  $staffQuery->where('role', 'staff')
                      ->whereIn('staff_type', ['teacher', 'instructor']);
              });
        })->withCount(['subjects', 'courses']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('staff_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $type = $request->type;
            if ($type === 'instructor') {
                $query->where('staff_type', 'instructor');
            } elseif ($type === 'teacher') {
                $query->where(function ($q) {
                    $q->where('role', 'teacher')
                      ->orWhere('staff_type', 'teacher');
                });
            }
        }

        $teachers = $query->latest()->paginate(15)->withQueryString();

        $students = User::where('role', 'student')
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        $stats = [
            'total' => User::where(function ($q) {
                $q->where('role', 'teacher')
                  ->orWhere(function ($staffQuery) {
                      $staffQuery->where('role', 'staff')
                          ->whereIn('staff_type', ['teacher', 'instructor']);
                  });
            })->count(),
            'instructors' => User::where(function($q) {
                $q->where('staff_type', 'instructor');
            })->count(),
            'teachers' => User::where(function ($q) {
                $q->where('role', 'teacher')
                  ->orWhere(function ($sq) {
                      $sq->where('role', 'staff')->where('staff_type', 'teacher');
                  });
            })->count(),
            'assigned_subjects' => Subject::whereNotNull('teacher_id')->count(),
        ];

        return view('sias.admin.teachers.index', compact('teachers', 'students', 'stats'));
    }

    public function createSias()
    {
        $this->authorizeStaffAccess();
        $students = User::where('role', 'student')->where('is_admin', false)->orderBy('name')->get();
        $subjects = Subject::with('course')->orderBy('title')->get();
        $courses = Course::orderBy('title')->get();

        return view('sias.admin.teachers.create', compact('students', 'subjects', 'courses'));
    }

    public function storeSias(Request $request)
    {
        $this->authorizeStaffAccess();

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'required_without:user_id|nullable|string|email|max:255|unique:users,email',
            'staff_type' => 'nullable|in:teacher,instructor',
            'password' => 'nullable|string|min:8|confirmed',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $staffType = $validated['staff_type'] ?? 'teacher';

        if (!empty($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);
            $user->update([
                'role' => 'teacher',
                'staff_type' => $staffType,
            ]);

            // Assign any selected subjects to this promoted teacher
            if (!empty($validated['subject_ids'])) {
                Subject::whereIn('id', $validated['subject_ids'])->update(['teacher_id' => $user->id]);
            }

            if (!empty($validated['course_ids'])) {
                Course::whereIn('id', $validated['course_ids'])
                    ->update(['instructor_id' => $user->id, 'instructor_name' => $user->name]);
            }

            return redirect()->route('sias.admin.teachers')
                ->with('success', $user->name . ' has been promoted to ' . ucfirst($staffType) . '.');
        }

        $user = User::create([
            'name' => $validated['name'] ?? 'New Teacher',
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'] ?? 'teacher1234'),
            'role' => 'teacher',
            'staff_type' => $staffType,
            'is_admin' => false,
        ]);

        // Assign any selected subjects to the new teacher
        if (!empty($validated['subject_ids'])) {
            Subject::whereIn('id', $validated['subject_ids'])->update(['teacher_id' => $user->id]);
        }

        if (!empty($validated['course_ids'])) {
            Course::whereIn('id', $validated['course_ids'])
                ->update(['instructor_id' => $user->id, 'instructor_name' => $user->name]);
        }

        return redirect()->route('sias.admin.teachers')
            ->with('success', $user->name . ' has been created as ' . ucfirst($staffType) . '.');
    }

    public function editSias(User $user)
    {
        $this->authorizeStaffAccess();
        $user->load(['subjects.course', 'courses']);
        $subjects = Subject::with('course')->orderBy('title')->get();
        $courses = Course::orderBy('title')->get();
        return view('sias.admin.teachers.edit', compact('user', 'subjects', 'courses'));
    }

    public function updateSias(Request $request, User $user)
    {
        $this->authorizeStaffAccess();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'staff_type' => 'nullable|in:teacher,instructor',
            'password' => 'nullable|string|min:8|confirmed',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'staff_type' => $validated['staff_type'] ?? 'teacher',
            'role' => 'teacher',
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // Sync subject assignments: unassign any subjects the teacher no longer has,
        // then assign selected subjects to this teacher.
        $subjectIds = $validated['subject_ids'] ?? [];
        Subject::where('teacher_id', $user->id)->whereNotIn('id', $subjectIds)->update(['teacher_id' => null]);
        if (!empty($subjectIds)) {
            Subject::whereIn('id', $subjectIds)->update(['teacher_id' => $user->id]);
        }

        $courseIds = $validated['course_ids'] ?? [];
        Course::where(function ($query) use ($user) {
            $query->where('instructor_id', $user->id)
                  ->orWhere('instructor_name', $user->name);
        })->whereNotIn('id', $courseIds)
          ->update(['instructor_id' => null, 'instructor_name' => null]);

        if (!empty($courseIds)) {
            Course::whereIn('id', $courseIds)
                ->update(['instructor_id' => $user->id, 'instructor_name' => $user->name]);
        }

        return redirect()->route('sias.admin.teachers')
            ->with('success', $user->name . ' has been updated successfully.');
    }

    public function demoteSias(User $user)
    {
        $this->authorizeStaffAccess();

        if ($user->role === 'teacher' || ($user->role === 'staff' && in_array($user->staff_type, ['teacher', 'instructor']))) {
            $user->update([
                'role' => 'student',
                'staff_type' => null,
            ]);

            return redirect()->route('sias.admin.teachers')
                ->with('success', $user->name . ' has been removed from teacher management.');
        }

        return redirect()->route('sias.admin.teachers')
            ->with('error', $user->name . ' is not currently assigned as a teacher.');
    }
}
