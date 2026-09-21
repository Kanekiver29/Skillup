@extends('teacher.layouts.master')
@section('title', 'Account Settings')
@section('page_title', 'Account Settings')
@section('content')
<div class="portal-page">
    <div class="portal-heading"><div><h2>Trainer Account</h2><p>Manage trainer information, account settings, and password security.</p></div><a class="portal-button" href="{{ route('teacher.profile.edit') }}">Edit trainer information</a></div>
    @if(session('success'))<div class="portal-card" style="color:#166534;background:#ecfdf5;">{{ session('success') }}</div>@endif
    <div class="portal-grid">
        <div class="portal-card"><h3>Trainer information</h3><p><strong>{{ $user->name }}</strong></p><p>{{ $user->email }}</p><p>{{ $user->staff_type ?? 'Teacher' }}</p></div>
        <div class="portal-card"><h3>Change password</h3><form method="POST" action="{{ route('teacher.account.password.update') }}" style="display:grid;gap:.7rem;">@csrf<input type="password" name="current_password" placeholder="Current password" required><input type="password" name="password" placeholder="New password" required><input type="password" name="password_confirmation" placeholder="Confirm new password" required><button class="portal-button" type="submit">Update password</button>@error('current_password')<small style="color:#b91c1c;">{{ $message }}</small>@enderror @error('password')<small style="color:#b91c1c;">{{ $message }}</small>@enderror</form></div>
    </div>
</div>
@endsection