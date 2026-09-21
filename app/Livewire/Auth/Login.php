<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Title;


#[Layout('auth.layouts.master')]
#[Title('Login')]
class Login extends Component
{
    public $identifier = '';
    public $password = '';
    public $login_as = 'student';
    public $remember = false;

    public function login()
    {
        // Validate input
        $rules = [
            'login_as' => 'required|in:admin,staff,teacher,student',
            'password' => 'required|min:6',
        ];

        // Identifier validation based on role
        if ($this->login_as === 'student') {
            $rules['identifier'] = 'required|string|min:3';
        } else {
            $rules['identifier'] = 'required|email';
        }

        $validated = $this->validate($rules);

        // Build credentials
        $credentialsAttempts = [
            'password' => $this->password,
        ];

        if ($this->login_as === 'student') {
            $identifier = $this->identifier;
            $credentialSets = [
                ['lrn' => $identifier, 'password' => $this->password],
                ['email' => $identifier, 'password' => $this->password],
            ];

            $authenticated = false;
            foreach ($credentialSets as $credentials) {
                if (Auth::attempt($credentials, $this->remember)) {
                    $authenticated = true;
                    break;
                }
            }

            if (!$authenticated) {
                $this->addError('identifier', 'The Student ID or email/password do not match our records.');
                return;
            }
        } else {
            $credentials = [
                'email' => $this->identifier,
                'password' => $this->password,
            ];

            if (!Auth::attempt($credentials, $this->remember)) {
                $this->addError('identifier', 'The email or password is incorrect.');
                return;
            }
        }

        session()->regenerate();
        $user = Auth::user();

        // Verify user role matches selection
        if (!$this->verifyUserRole($user)) {
            Auth::logout();
            session()->invalidate();
            $this->addError('login_as', 'This account does not have access as ' . ucfirst($this->login_as) . '.');
            return;
        }

        // Always open the selected role's dashboard after login.
        return redirect()->route($this->getRedirectRoute())->with('success', 'Welcome back!');
    }

    /**
     * Verify user's role matches selected login role
     */
    private function verifyUserRole($user): bool
    {
        $role = strtolower((string) ($user->role ?? ''));
        $staffType = strtolower((string) ($user->staff_type ?? ''));

        return match ($this->login_as) {
            'admin' => $user->isAdmin(),
            'teacher' => $role === 'teacher' || in_array($staffType, ['teacher', 'instructor'], true),
            'staff' => (int) $user->is_admin === 1
                || $role === 'admin'
                || ($role === 'staff' && !in_array($staffType, ['teacher', 'instructor'], true)),
            'student' => $role === '' || $role === 'student',
            default => false,
        };
    }

    /**
     * Get redirect route based on role
     */
    private function getRedirectRoute(): string
    {
        return match ($this->login_as) {
            'admin' => 'admin.dashboard',
            'teacher' => 'teacher.dashboard',
            'staff' => 'staff.dashboard',
            'student' => 'userpage.home',
            default => 'dashboard',
        };
    }

    public function render()
    {
        return view('auth.login');
    }
}
