@extends('sias.students.layout.master')

@section('title', 'Student Account')
@section('page_title', 'Account Settings')

@section('content')
<div class="page-card">
    <h2>Student Account Settings</h2>
    <p>Manage your student account information and security settings.</p>
    <div class="section-block"><strong>Name:</strong> {{ auth()->user()->name ?? 'Student Name' }}</div>
    <div class="section-block"><strong>Email:</strong> {{ auth()->user()->email ?? 'student@example.com' }}</div>
    <div class="section-block"><strong>Role:</strong> Student</div>
    <div class="section-block">
        <a href="{{ route('sias.student.account.password') }}" class="btn-black">Change Password</a>
        <a href="{{ route('sias.student.account.mfa') }}" class="btn-white">Multi-Factor Authentication</a>
    </div>
</div>
@endsection
