@extends('auth.layouts.master')

@section('title', $portal === 'sias-admin' ? 'SIAS Administrator Login' : 'Course Login')

@section('auth-content')
<div class="min-h-screen flex items-center justify-center bg-slate-100 px-4 py-10">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
        <div class="mb-8 text-center">
            <img src="{{ asset('image/logo new.jpg') }}" alt="SkillUp" class="mx-auto mb-4 h-16 w-16 rounded-xl object-cover">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-cyan-700">{{ $portal === 'sias-admin' ? 'SIAS Administration' : 'SkillUp Courses' }}</p>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $portal === 'sias-admin' ? 'Administrator sign in' : 'Course sign in' }}</h1>
            <p class="mt-2 text-sm text-slate-500">Use your existing account. One account works across both portals.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ $portal === 'sias-admin' ? route('sias.admin.login.submit') : route('course.login.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full rounded-lg border border-slate-300 px-3 py-3 text-slate-900 outline-none transition focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-lg border border-slate-300 px-3 py-3 text-slate-900 outline-none transition focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-cyan-700 focus:ring-cyan-600">
                Remember this account
            </label>
            <button type="submit" class="w-full rounded-lg bg-cyan-700 px-4 py-3 font-semibold text-white transition hover:bg-cyan-800 focus:outline-none focus:ring-4 focus:ring-cyan-200">
                Sign in to {{ $portal === 'sias-admin' ? 'SIAS Admin' : 'Courses' }}
            </button>
        </form>

        <div class="mt-6 flex justify-between text-sm">
            <a href="{{ $portal === 'sias-admin' ? route('course.login') : route('sias.admin.login') }}" class="font-semibold text-cyan-700 hover:text-cyan-900">
                {{ $portal === 'sias-admin' ? 'Course login' : 'SIAS admin login' }}
            </a>
            <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-800">Other login</a>
        </div>
    </div>
</div>
@endsection
