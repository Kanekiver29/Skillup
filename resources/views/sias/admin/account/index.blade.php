@extends('sias.admin.layouts.master')

@section('title', 'Admin Account')
@section('page_title', 'Account Settings')

@section('content')
<div class="admin-card">
    <h2 data-i18n="admin_account_settings">Admin Account Settings</h2>
    <p data-i18n="manage_account_details">Manage your SIAS administrator account details and login information.</p>
    <div class="admin-panel"><strong data-i18n="name">Name</strong>: {{ auth()->user()->name ?? 'Admin Name' }}</div>
    <div class="admin-panel"><strong data-i18n="email">Email</strong>: {{ auth()->user()->email ?? 'admin@example.com' }}</div>
    <div class="admin-panel"><strong data-i18n="role">Role</strong>: <span data-i18n="admin">Admin</span></div>
</div>
@endsection
