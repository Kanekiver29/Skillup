<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No account found for that email.']);
        }

        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );

        // For development, show the reset link instead of emailing
        $link = url('/password/reset/' . $token) . '?email=' . urlencode($email);

        return view('auth.passwords.email_sent', ['link' => $link, 'email' => $email]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->query('email');
        return view('auth.passwords.reset')->with(['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->input('email'))->first();
        if (!$record || !hash_equals($record->token, $request->input('token'))) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        // Token expiry: 60 minutes
        $created = Carbon::parse($record->created_at);
        if ($created->diffInMinutes(now()) > 60) {
            return back()->withErrors(['token' => 'Token expired. Please request a new reset link.']);
        }

        $user = User::where('email', $request->input('email'))->firstOrFail();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // delete token
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return redirect('/login')->with('status', 'Password reset successful. You may now log in.');
    }
}
