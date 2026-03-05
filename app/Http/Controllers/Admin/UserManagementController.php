<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Show all admin accounts.
     */
    public function showAdmins()
    {
        $this->authorizeAdmin();

        // simply fetch all users marked as admin
        $admins = User::where('is_admin', true)->get();

        return view('Admin.users.admins', [
            'admins' => $admins,
        ]);
    }

    /**
     * Show all users.
     */
    public function showUsers()
    {
        $this->authorizeAdmin();

        $users = User::where('is_admin', false)->latest()->paginate(15);

        return view('Admin.users.list', [
            'users' => $users,
        ]);
    }

    /**
     * Make a user an admin.
     */
    public function makeAdmin(User $user)
    {
        $this->authorizeAdmin();

        $user->update(['is_admin' => true]);

        return back()->with('success', "{$user->name} is now an admin.");
    }

    /**
     * Remove admin privileges from a user.
     */
    public function removeAdmin(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot remove your own admin privileges.');
        }

        $user->update(['is_admin' => false]);

        return back()->with('success', "Admin privileges removed from {$user->name}.");
    }

    /**
     * Show edit form for a user.
     */
    public function editUser(User $user)
    {
        $this->authorizeAdmin();

        return view('Admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update user information.
     */
    public function updateUser(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', "{$user->name} has been updated successfully.");
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users')->with('success', "{$userName} has been deleted successfully.");
    }

    /**
     * Authorize that the current user is an admin.
     */
    private function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
    }
}
