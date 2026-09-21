@extends('sias.admin.layouts.master')

@section('title', 'User & Role Management')
@section('page_title', 'User & Role Management')

@section('content')
<div class="admin-card">
  <p>Manage user accounts, administrators, and roles.</p>
  <div class="admin-actions"><a href="{{ url('/admin/users/create') }}">Add user</a></div>
</div>
@endsection
