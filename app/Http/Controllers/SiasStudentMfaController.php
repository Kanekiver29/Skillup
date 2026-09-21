<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiasStudentMfaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Use session to simulate MFA state since there's no DB column yet
        $mfaEnabled = session('mfa_enabled_' . $user->id, false);
        $mfaMethod = session('mfa_method_' . $user->id, 'app');

        return view('sias.students.account.mfa', compact('user', 'mfaEnabled', 'mfaMethod'));
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();
        $action = $request->input('action');

        if ($action === 'enable') {
            session(['mfa_enabled_' . $user->id => true]);
            session(['mfa_method_' . $user->id => $request->input('method', 'app')]);
            return redirect()->back()->with('success', 'Multi-Factor Authentication has been successfully enabled.');
        } else {
            session(['mfa_enabled_' . $user->id => false]);
            return redirect()->back()->with('info', 'Multi-Factor Authentication is now disabled.');
        }
    }
}
