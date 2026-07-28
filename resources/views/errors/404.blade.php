@extends('teacher.layouts.master')

@section('title', 'Page Not Found')

@section('content')
<div class="error-page" style="text-align:center; margin-top:3rem;">
    <h1 style="font-size:4rem; color:#e63946;">404 - Not Found</h1>
    <p style="font-size:1.25rem; margin:1rem 0;">Sorry, the page you are looking for could not be found.</p>
    <a href="{{ route('teacher.dashboard') }}" class="btn btn-primary" style="padding:0.75rem 1.5rem; font-size:1rem;">Go to Dashboard</a>
</div>
@endsection
