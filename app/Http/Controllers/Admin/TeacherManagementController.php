<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('staff_type', 'like', "%{$search}%");
            });
        }

        $teachers = $query->latest()->paginate(15)->withQueryString();

        $students = User::where('role', 'student')
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        $stats = [
            'total' => $teachers->total(),
            'active' => User::where(function ($q) {
                $q->where('role', 'teacher')
                  ->orWhere(function ($staffQuery) {
                      $staffQuery->where('role', 'staff')
                          ->whereIn('staff_type', ['teacher', 'instructor']);
                  });
            })->count(),
            'instructors' => User::where('role', 'staff')->where('staff_type', 'instructor')->count(),
            'teachers' => User::where('role', 'staff')->where('staff_type', 'teacher')->count(),
        ];

        return view('Admin.teachers.index', compact('teachers', 'students', 'stats'));
    }

    public function store(Request $request)
    {
        $this->authorizeStaffAccess();

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'required_without:user_id|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);
            $user->update([
                'role' => 'teacher',
                'staff_type' => 'teacher',
            ]);

            return redirect()->route('admin.teachers.index')
                ->with('success', $user->name . ' has been promoted to teacher.');
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
            ->with('success', $user->name . ' has been created as a teacher.');
    }

    public function demote(User $user)
    {
        $this->authorizeStaffAccess();

        if ($user->role === 'teacher') {
            $user->update([
                'role' => 'student',
                'staff_type' => null,
            ]);

            return redirect()->route('admin.teachers.index')
                ->with('success', $user->name . ' has been removed from teacher management.');
        }

        if ($user->role === 'staff' && in_array($user->staff_type, ['teacher', 'instructor'])) {
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
}
