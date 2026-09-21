@extends('sias.admin.layouts.master')

@section('title', 'Admin Change Password')
@section('page_title', 'Change Password')

@section('content')
<div class="admin-card">
    <h2 data-i18n="change_password">Change Password</h2>
    <p data-i18n="update_password_secure">Update your admin account password to keep SIAS secure.</p>
    <div class="admin-panel"><strong data-i18n="password_note">Note</strong>: <span data-i18n="password_note">Use a strong password and do not share your credentials.</span></div>
</div>
@endsection
