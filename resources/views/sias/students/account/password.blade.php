@extends('sias.students.layout.master')

@section('title', 'Student Change Password')
@section('page_title', 'Change Password')

@section('content')
<div class="page-card" style="max-width:720px">
    <h2>Change Password</h2>
    <p>Update your student account password to keep your account secure.</p>

    @if(session('success'))
        <div class="section-block" style="border-left:4px solid #16a34a;background:#ecfdf5;color:#166534;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="section-block" style="border-left:4px solid #dc2626;background:#fee2e2;color:#991b1b;">
            <ul style="margin:0;padding-left:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('account.password.update') }}" style="display:grid;gap:1rem;margin-top:1rem">
        @csrf
        @method('PUT')

        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#0f172a;">Current Password</span>
            <input type="password" name="current_password" required class="form-input" autocomplete="current-password">
        </label>

        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#0f172a;">New Password</span>
            <input type="password" name="password" required class="form-input" autocomplete="new-password">
        </label>

        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#0f172a;">Confirm New Password</span>
            <input type="password" name="password_confirmation" required class="form-input" autocomplete="new-password">
        </label>

        <button type="submit" class="btn-black">Save New Password</button>
    </form>
</div>
@endsection
