@extends('auth.layouts.master')

@section('title', 'Reset Password')

@push('head')
<style>
    .auth-card {
        max-width: 520px;
        width: 100%;
        margin: 2rem auto;
        background: rgba(8, 14, 28, 0.95);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 1.25rem;
        box-shadow: 0 32px 80px rgba(0,0,0,0.55);
        overflow: hidden;
    }
    .auth-header {
        padding: 2rem;
        text-align: center;
    }
    .auth-header h1 {
        margin: 0 0 0.75rem;
        font-size: 1.9rem;
        color: #ffffff;
    }
    .auth-header p {
        margin: 0;
        color: rgba(207,228,255,0.72);
    }
    .auth-body {
        padding: 1.75rem 2rem 2rem;
    }
    .auth-field { margin-bottom: 1rem; }
    .auth-field label {
        display: block;
        margin-bottom: 0.5rem;
        color: rgba(207,228,255,0.74);
        font-size: 0.95rem;
    }
    .auth-input {
        width: 100%;
        padding: 0.95rem 1rem;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 0.85rem;
        background: rgba(255,255,255,0.04);
        color: #f8fbff;
        font-size: 0.95rem;
    }
    .auth-input::placeholder { color: rgba(207,228,255,0.45); }
    .auth-btn-primary {
        width: 100%;
        padding: 0.95rem;
        border: 0;
        border-radius: 0.95rem;
        font-weight: 700;
        color: #04121f;
        background: linear-gradient(110deg, #00e6ff 0%, #7dd8ff 45%, #fdb913 100%);
        cursor: pointer;
    }
    .auth-alert { margin-bottom: 1rem; padding: 1rem 1.1rem; border-radius: 0.95rem; background: rgba(255,47,82,0.12); color: #ffb3bf; border: 1px solid rgba(255,47,82,0.22); display: flex; gap: 0.75rem; align-items: center; }
    .auth-alert i { font-size: 1rem; }
    .auth-copy { color: rgba(207,228,255,0.72); font-size: 0.95rem; line-height: 1.6; }
    .auth-link { color: #7dd8ff; text-decoration: underline; }
</style>
@endpush

@section('auth-content')
<div class="auth-scope auth-shell">
    <div class="auth-card">
        <header class="auth-header">
            <h1>Reset Password</h1>
            <p>Enter your email address and we’ll send a password reset link.</p>
        </header>
        <div class="auth-body">
            @if($errors->any())
                <div class="auth-alert" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ url('/password/email') }}">
                @csrf
                <div class="auth-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" class="auth-input" placeholder="you@example.com">
                </div>
                <button type="submit" class="auth-btn-primary">Send reset link</button>
            </form>
            <p class="auth-copy" style="margin-top:1rem">Check your inbox after submitting. If you don’t see the message, also check spam.</p>
        </div>
    </div>
</div>
@endsection
