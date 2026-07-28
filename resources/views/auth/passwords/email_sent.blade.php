@extends('auth.layouts.master')

@section('title', 'Reset Link Sent')

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
    .auth-header p { margin: 0; color: rgba(207,228,255,0.72); }
    .auth-body { padding: 1.75rem 2rem 2rem; }
    .auth-copy { color: rgba(207,228,255,0.72); line-height: 1.75; }
    .auth-link { color: #7dd8ff; text-decoration: underline; }
</style>
@endpush

@section('auth-content')
<div class="auth-scope auth-shell">
    <div class="auth-card">
        <header class="auth-header">
            <h1>Reset Link Generated</h1>
            <p>Your request is on its way.</p>
        </header>
        <div class="auth-body">
            <p class="auth-copy">A reset link was generated for <strong>{{ $email }}</strong>.</p>
            <p class="auth-copy">For development, use this link to reset the password:</p>
            <p class="auth-copy"><a href="{{ $link }}" class="auth-link">{{ $link }}</a></p>
        </div>
    </div>
</div>
@endsection
