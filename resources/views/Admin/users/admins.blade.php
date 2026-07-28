@extends('layout.Admin.system')

@section('title', 'Admin Accounts')

@section('content')
<div class="space-y-6">
    <header data-admin-animate class="admin-page-hero p-6 md:p-8 text-white relative z-[1]">
        <div class="relative z-[2] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-sky-200 mb-2">
                    <i class="fas fa-user-shield"></i> Administrator access
                </span>
                <h1 class="text-2xl md:text-3xl font-bold">Admin accounts</h1>
                <p class="text-slate-300 text-sm mt-1">Manage users with full administrator privileges.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.staff.index') }}" class="admin-btn admin-btn-secondary !bg-white/10 !text-white !border-white/20 hover:!bg-white/20">
                    <i class="fas fa-user-tie"></i> Staff admin
                </a>
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-primary">
                    <i class="fas fa-users"></i> All users
                </a>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="admin-alert p-4 bg-emerald-50 text-emerald-800 border border-emerald-200" data-admin-animate>
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-alert p-4 bg-red-50 text-red-800 border border-red-200" data-admin-animate>
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div data-admin-animate class="admin-delay-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="admin-stat-card p-5 text-center sm:text-left">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total admins</p>
            <p class="text-3xl font-bold text-slate-900 mt-1" data-admin-count="{{ $admins->count() }}">{{ $admins->count() }}</p>
        </div>
        <div class="admin-stat-card p-5 flex items-center gap-4 sm:col-span-2">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <i class="fas fa-shield-halved text-[#003a8f] text-xl"></i>
            </div>
            <div>
                <p class="font-semibold text-slate-900">Protected accounts</p>
                <p class="text-sm text-slate-500">Your own account cannot be demoted from this screen.</p>
            </div>
        </div>
    </div>

    <div data-admin-animate class="admin-delay-2 admin-card admin-table-wrap">
        <div class="overflow-x-auto">
            <table class="admin-table w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wide">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admins as $admin)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow" style="background: linear-gradient(135deg, #003a8f, #0a2540);">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $admin->name }}</p>
                                        @if($admin->id === auth()->id())
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#003a8f]">You</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $admin->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                @if($admin->id !== auth()->id())
                                    <form action="{{ route('admin.remove-admin', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Remove admin privileges from this user?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-red-600 hover:bg-red-50 rounded-lg text-xs font-semibold transition">
                                            <i class="fas fa-user-minus mr-1"></i> Remove admin
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-lock mr-1"></i> Current session
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <i class="fas fa-user-shield text-4xl text-slate-300 mb-3 block"></i>
                                No admin accounts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div data-admin-animate class="flex flex-wrap gap-2">
        <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to dashboard
        </a>
    </div>
</div>

@endsection
