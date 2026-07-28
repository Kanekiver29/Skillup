<?php

namespace App\Http\Controllers;

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

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'login_as' => 'required|in:admin,staff,teacher,student',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

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
                        ->withInput($request->only('email', 'login_as'))
                        ->withErrors(['login_as' => 'This account does not have Administrator access.']);
                }
                return redirect('/admin')->with('success', 'Welcome back, Admin!');
            }

            if ($loginAs === 'teacher') {
                if (!method_exists($user, 'isTeacher') || !$user->isTeacher()) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('email', 'login_as'))
                        ->withErrors(['login_as' => 'This account is not registered as an Instructor.']);
                }

                return redirect()->route('teacher.dashboard')->with('success', 'Welcome back, Instructor!');
            }

            if ($loginAs === 'staff') {
                // Allow users with staff role or admin flag to sign in as staff
                if (!($user->role === 'staff' || $user->hasStaffAccess())) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('email', 'login_as'))
                        ->withErrors(['login_as' => 'This account is not registered as Staff.']);
                }

                return redirect()->route('staff.dashboard')->with('success', 'Welcome back, Staff!');
            }

            if ($loginAs === 'student') {
                if ($user->hasStaffAccess()) {
                    Auth::logout();
                    return back()
                        ->withInput($request->only('email', 'login_as'))
                        ->withErrors(['login_as' => 'Please use a student account or choose the correct role.']);
                }
                return redirect()->intended('/')->with('success', 'Login successful!');
            }
        }

        // Authentication failed
        return back()
            ->withInput($request->only('email', 'login_as'))
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    /**
     * Show the register form.
     */
    public function showRegister()
    {
        return view('auth.resgister');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
            ],
            'age' => 'required|integer|min:1|max:120',
            'birthday' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'terms' => 'required|accepted',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'age' => $validated['age'],
            'birthday' => $validated['birthday'],
            'location' => $validated['address'],
        ]);

        // Log the user in
        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful! Welcome to SkillUp!');
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
}
