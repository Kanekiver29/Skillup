@extends('sias.admin.layouts.master')

@section('title', 'Create User')
@section('page_title', 'Create User')
@section('subtitle', 'Create a new user account and assign the proper role.')

@section('content')
<style>
  .user-form-card {
    max-width: 860px;
    margin: 0 auto;
    padding: 28px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 18px;
    box-shadow: var(--card-shadow);
  }

  .user-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 16px;
  }

  .user-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .user-field.full {
    grid-column: 1 / -1;
  }

  .user-field label {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text);
  }

  .user-field label .req {
    color: var(--danger);
  }

  .user-input,
  .user-select {
    width: 100%;
    min-height: 44px;
    padding: 0.7rem 0.8rem;
    border-radius: 10px;
    border: 1px solid var(--card-border);
    background: var(--bg);
    color: var(--text);
    font: inherit;
  }

  .user-input:focus,
  .user-select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }

  .user-help {
    font-size: 0.78rem;
    color: var(--text-muted);
  }

  .user-errors {
    margin-bottom: 20px;
    padding: 14px 18px;
    border-radius: 12px;
    border: 1px solid rgba(239, 68, 68, 0.28);
    background: rgba(239, 68, 68, 0.08);
    color: var(--danger);
  }

  .user-errors ul {
    margin: 8px 0 0 18px;
    padding: 0;
  }

  .user-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--card-border);
  }

  @media (max-width: 720px) {
    .user-form-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="user-form-card">
  @if($errors->any())
    <div class="user-errors">
      <strong>Please fix the following errors:</strong>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('sias.admin.users.store') }}" id="user-create-form">
    @csrf

    <div class="user-form-grid">
      <div class="user-field full">
        <label for="name">Full name <span class="req">*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" class="user-input" required>
      </div>

      <div class="user-field">
        <label for="email">Email address <span class="req">*</span></label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" class="user-input" required>
      </div>

      <div class="user-field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="{{ old('username') }}" class="user-input" placeholder="Optional; auto-generated if left blank">
      </div>

      <div class="user-field">
        <label for="role">Role <span class="req">*</span></label>
        <select id="role" name="role" class="user-select" required>
          <option value="">Select a role</option>
          @foreach(['student', 'staff', 'teacher', 'admin', 'sias_admin'] as $role)
            <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
          @endforeach
        </select>
      </div>

      <div class="user-field">
        <label for="department">Department</label>
        <input id="department" name="department" type="text" value="{{ old('department') }}" class="user-input" placeholder="e.g. Academic, IT, Admin">
      </div>

      <div class="user-field">
        <label for="staff_type">Staff type</label>
        <select id="staff_type" name="staff_type" class="user-select">
          <option value="">Not applicable</option>
          @foreach(['teacher', 'instructor', 'moderator', 'content_manager', 'support'] as $staffType)
            <option value="{{ $staffType }}" @selected(old('staff_type') === $staffType)>{{ ucfirst(str_replace('_', ' ', $staffType)) }}</option>
          @endforeach
        </select>
      </div>

      <div class="user-field">
        <label for="password">Password <span class="req">*</span></label>
        <input id="password" name="password" type="password" class="user-input" required minlength="8" autocomplete="new-password">
      </div>

      <div class="user-field">
        <label for="password_confirmation">Confirm password <span class="req">*</span></label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="user-input" required minlength="8" autocomplete="new-password">
      </div>

      <div class="user-field full">
        <label>
          <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin'))>
          Mark as admin access
        </label>
        <small class="user-help">This is useful for custom admin accounts, although role selection already grants admin privileges for the admin roles.</small>
      </div>
    </div>

    <div class="user-actions">
      <a href="{{ route('sias.admin.users') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Create user</button>
    </div>
  </form>
</div>

<script>
  const createForm = document.getElementById('user-create-form');
  const nameInput = document.getElementById('name');
  const usernameInput = document.getElementById('username');

  if (createForm && nameInput && usernameInput) {
    const syncUsername = () => {
      if (!usernameInput.value.trim()) {
        const seed = nameInput.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '');
        usernameInput.value = seed || '';
      }
    };

    nameInput.addEventListener('input', syncUsername);
    syncUsername();
  }
</script>
@endsection
