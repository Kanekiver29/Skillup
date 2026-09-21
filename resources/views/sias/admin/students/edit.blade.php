@extends('sias.admin.layouts.master')

@section('title', 'Edit Student')
@section('page_title', 'Edit Student')

@section('content')
<div class="admin-card">
  <div style="margin-bottom:1.5rem;">
    <h2 style="margin:0;font-size:1.5rem;">Edit Student Profile</h2>
    <p style="margin:.25rem 0 0;color:var(--text-muted);">Update personal information for {{ $user->name }}</p>
  </div>

  @if($errors->any())
    <div style="padding:.75rem 1rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#dc2626;border-radius:8px;margin-bottom:1rem;">
      <ul style="margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('sias.admin.students.update', $user->id) }}">
    @csrf
    @method('PUT')
    <div style="display:grid;gap:1rem;max-width:560px">
      <label style="display:grid;gap:.35rem;font-weight:600;">
        Student ID (LRN)
        <input name="student_id" required class="form-input" value="{{ old('student_id', $user->lrn) }}">
      </label>

      <label style="display:grid;gap:.35rem;font-weight:600;">
        Full Name
        <input name="name" required class="form-input" value="{{ old('name', $user->name) }}">
      </label>

      <label style="display:grid;gap:.35rem;font-weight:600;">
        Email Address
        <input name="email" type="email" required class="form-input" value="{{ old('email', $user->email) }}">
      </label>

      <label style="display:grid;gap:.35rem;font-weight:600;">
        Age
        <input name="age" type="number" min="1" max="120" class="form-input" value="{{ old('age', $user->age) }}">
      </label>

      <div style="display:flex;gap:.75rem;margin-top:1rem;">
        <button type="submit" style="padding:.75rem 1.5rem;background:#1d4ed8;color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;">Update Student</button>
        <a href="{{ route('sias.admin.students.index') }}" style="padding:.75rem 1.5rem;background:var(--block-bg);border:1px solid var(--block-border);color:var(--text);border-radius:8px;text-decoration:none;font-weight:600;">Cancel</a>
      </div>
    </div>
  </form>
</div>
@endsection
