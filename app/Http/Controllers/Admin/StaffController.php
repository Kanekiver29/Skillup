<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Authorize that the current user is staff.
     */
    protected function authorizeStaff()
    {
        if (!auth()->check() || auth()->user()->role !== 'staff') {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Show all staff members.
     */
    public function index(Request $request)
    {
        $this->authorizeStaff();

        $query = User::where('role', 'staff');

        if ($request->filled('staff_type')) {
            $query->where('staff_type', $request->staff_type);
        }

        $staff = $query->latest()->paginate(15)->withQueryString();
        $staffTypes = User::STAFF_TYPES;

        // Report metrics
        $totalStaff = User::where('role', 'staff')->count();

        // Staff breakdown by type
        $staffByType = [];
        foreach ($staffTypes as $key => $type) {
            $staffByType[$key] = [
                'label' => $type['label'],
                'count' => User::where('role', 'staff')->where('staff_type', $key)->count(),
                'icon' => $type['icon'],
                'color' => $type['color'],
            ];
        }

        // Recent staff additions (last 5)
        $recentStaff = User::where('role', 'staff')
            ->latest()
            ->take(5)
            ->get();

        return view('Admin.staff.index', [
            'staff' => $staff,
            'staffTypes' => $staffTypes,
            'totalStaff' => $totalStaff,
            'staffByType' => $staffByType,
            'recentStaff' => $recentStaff,
        ]);
    }

    /**
     * Show the form to create a new staff admin.
     */
    public function create()
    {
        $this->authorizeStaff();

        $users = User::where('role', 'student')
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        $staffTypes = User::STAFF_TYPES;

        return view('Admin.staff.create', [
            'users' => $users,
            'staffTypes' => $staffTypes,
        ]);
    }

    /**
     * Promote a user to staff role.
     */
    public function store(Request $request)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'staff_type' => 'required|in:' . implode(',', array_keys(User::STAFF_TYPES)),
        ]);

        $user = User::findOrFail($validated['user_id']);

        if ($user->role === 'staff') {
            return back()->with('error', "{$user->name} is already a staff member.");
        }

        $user->update([
            'role' => 'staff',
            'staff_type' => $validated['staff_type'],
        ]);

        $typeLabel = User::STAFF_TYPES[$validated['staff_type']]['label'];

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} has been promoted to {$typeLabel}.");
    }

    /**
     * Show the transfer page for an existing staff member.
     */
    public function showTransfer(User $user)
    {
        $this->authorizeStaff();

        if ($user->role !== 'staff') {
            return redirect()->route('admin.staff.index')
                ->with('error', "{$user->name} is not currently assigned as staff.");
        }

        return view('Admin.staff.transfer', [
            'user' => $user,
            'staffTypes' => User::STAFF_TYPES,
        ]);
    }

    /**
     * Update the staff type for an existing staff member.
     */
    public function transfer(Request $request, User $user)
    {
        $this->authorizeStaff();

        if ($user->role !== 'staff') {
            return redirect()->route('admin.staff.index')
                ->with('error', "{$user->name} is not a staff member.");
        }

        $validated = $request->validate([
            'staff_type' => 'required|in:' . implode(',', array_keys(User::STAFF_TYPES)),
        ]);

        if ($validated['staff_type'] === $user->staff_type) {
            return redirect()->route('admin.staff.index')
                ->with('success', "{$user->name} already belongs to that staff type.");
        }

        $user->update(['staff_type' => $validated['staff_type']]);

        $typeLabel = User::STAFF_TYPES[$validated['staff_type']]['label'];

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} has been transferred to {$typeLabel}.");
    }

    /**
     * Remove staff role from a user (demote to student).
     */
    public function demote(User $user)
    {
        $this->authorizeStaff();

        if ($user->role !== 'staff') {
            return back()->with('error', "{$user->name} is not a staff member.");
        }

        $user->update(['role' => 'student', 'staff_type' => null]);

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} has been removed from staff.");
    }

    /**
     * Show the staff registration form.
     */
    public function showRegister()
    {
        $this->authorizeStaff();

        $staffTypes = User::STAFF_TYPES;

        return view('Admin.staff.register', compact('staffTypes'));
    }

    /**
     * Handle staff account registration.
     */
    public function register(Request $request)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'staff_type' => 'required|in:' . implode(',', array_keys(User::STAFF_TYPES)),
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'staff_type' => $validated['staff_type'],
        ]);

        $typeLabel = User::STAFF_TYPES[$validated['staff_type']]['label'];

        return redirect()->route('admin.staff.index')
            ->with('success', "{$typeLabel} account for {$user->name} has been created successfully.");
    }
}
