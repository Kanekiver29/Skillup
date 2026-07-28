@extends('layout.Admin.system')

@section('title', 'Backup & Recovery - SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Backup & Recovery</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">Backup & Recovery</span>
                </nav>
            </div>
            <div class="text-sm text-gray-600 bg-cyan-50 border border-cyan-100 rounded-lg px-4 py-3">
                <p class="font-medium text-cyan-700">{{ strtoupper($driver) }} database</p>
                <p class="text-cyan-600">Connected: {{ $connection }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-5 text-emerald-900">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-emerald-600 mt-1"></i>
                    <div>
                        <p class="font-semibold">Success</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 rounded-lg p-5 text-rose-900">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-rose-600 mt-1"></i>
                    <div>
                        <p class="font-semibold">Error</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Backup history</h2>
                        <p class="text-sm text-gray-500 mt-1">Create and restore database backups from this page.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <form action="{{ route('admin.backup.fullBackup') }}" method="POST" class="inline-flex items-center gap-3">
                            @csrf
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" name="include_all" value="1" class="h-4 w-4">
                                <span class="text-sm">Include everything (vendor, node_modules)</span>
                            </label>
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                <i class="fas fa-file-archive"></i>
                                Full Backup
                            </button>
                        </form>
                        <form action="{{ route('admin.backup.store') }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-cyan-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700">
                                <i class="fas fa-database"></i>
                                DB Backup Only
                            </button>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">File</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">Type</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">Size</th>
                                <th class="px-5 py-4 text-left font-semibold text-gray-600 uppercase tracking-wide">Modified</th>
                                <th class="px-5 py-4 text-right font-semibold text-gray-600 uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($backupFiles as $file)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-4 text-gray-900 font-medium">
                                        <i class="fas {{ $file['type'] === 'Full Backup' ? 'fa-box' : 'fa-database' }} text-gray-400 mr-2"></i>
                                        {{ $file['name'] }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        <span class="inline-flex items-center gap-1 rounded-full {{ $file['type'] === 'Full Backup' ? 'bg-emerald-100 text-emerald-800 px-3 py-1' : 'bg-cyan-100 text-cyan-800 px-3 py-1' }} text-xs font-semibold">
                                            {{ $file['type'] }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">
                                        @if($file['size'] > 1024*1024*1024)
                                            {{ number_format($file['size'] / (1024*1024*1024), 2) }} GB
                                        @elseif($file['size'] > 1024*1024)
                                            {{ number_format($file['size'] / (1024*1024), 2) }} MB
                                        @else
                                            {{ number_format($file['size'] / 1024, 2) }} KB
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-gray-700">{{ \Carbon\Carbon::createFromTimestamp($file['modified'])->format('M d, Y H:i') }}</td>
                                    <td class="px-5 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.backup.download', urlencode($file['name'])) }}" class="inline-flex items-center gap-2 rounded-lg border border-cyan-100 bg-cyan-50 px-4 py-2 text-xs font-semibold text-cyan-700 hover:bg-cyan-100">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                                        @if($file['type'] === 'Database')
                                            <form action="{{ route('admin.backup.restore') }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="backup_file" value="{{ $file['name'] }}">
                                                <button type="submit" onclick="return confirm('Restore database from {{ $file['name'] }}? This will overwrite current data.')" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                                    <i class="fas fa-undo"></i>
                                                    Restore
                                                </button>
                                            </form>
                                        @endif
                                        @if($file['type'] === 'Full Backup')
                                            <form action="{{ route('admin.backup.restore') }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="backup_file" value="{{ $file['name'] }}">
                                                <div class="flex flex-wrap items-center gap-2 mb-2 text-xs text-slate-600">
                                                    <label class="inline-flex items-center gap-2">
                                                        <input type="checkbox" name="confirm" value="yes" class="h-4 w-4" required>
                                                        <span>I understand this will overwrite files</span>
                                                    </label>
                                                    <label class="inline-flex items-center gap-2">
                                                        <input type="checkbox" name="overwrite_env" value="1" class="h-4 w-4">
                                                        <span>Overwrite .env</span>
                                                    </label>
                                                </div>
                                                <button type="submit" onclick="return confirm('Perform full restore from {{ $file['name'] }}? This will overwrite application files. Proceed?')" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                                    <i class="fas fa-undo"></i>
                                                    Restore
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500">No backups have been created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <aside class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Recovery checklist</h3>
                    <p class="text-sm text-gray-500 mt-2">Use this module to create fail-safe snapshots and restore the DB quickly.</p>
                </div>
                @if(isset($diagnostics))
                    <div class="rounded-lg border border-slate-100 bg-white p-4">
                        <p class="font-semibold text-slate-800">Diagnostics</p>
                        <ul class="text-sm text-gray-600 mt-2 space-y-2">
                            <li><strong>ZIP extension:</strong> <span class="font-medium">{{ $diagnostics['zip'] ? 'available' : 'missing' }}</span></li>
                            <li><strong>PharData:</strong> <span class="font-medium">{{ $diagnostics['phar'] ? 'available' : 'missing' }}</span></li>
                            <li><strong>phar.readonly:</strong> <span class="font-medium">{{ $diagnostics['phar_readonly'] }}</span></li>
                            <li><strong>temp dir:</strong> <span class="font-medium">{{ $diagnostics['temp_dir'] }}</span></li>
                            <li><strong>open_basedir:</strong> <span class="font-medium">{{ $diagnostics['open_basedir'] }}</span></li>
                            <li><strong>backup dir:</strong> <span class="font-medium">{{ $diagnostics['backup_dir'] }}</span></li>
                            <li><strong>backup dir writable:</strong> <span class="font-medium">{{ $diagnostics['backup_dir_writable'] ? 'yes' : 'no' }}</span></li>
                        </ul>
                    </div>
                    @if($diagnostics['log_tail'])
                        <div class="rounded-lg border border-rose-100 bg-rose-50 p-3">
                            <p class="font-semibold text-rose-800">Recent log (tail)</p>
                            <pre class="mt-2 text-xs text-rose-900 whitespace-pre-wrap">{{ $diagnostics['log_tail'] }}</pre>
                        </div>
                    @endif
                @endif
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="font-semibold text-emerald-700">Full Backup</p>
                        <p class="mt-1">Creates a ZIP archive with all application files and database backup. Perfect for complete system recovery.</p>
                    </div>
                    <div class="rounded-xl border border-cyan-100 bg-cyan-50 p-4">
                        <p class="font-semibold text-cyan-700">Database Only</p>
                        <p class="mt-1">Creates a database backup only. Smaller file size, faster backup process.</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white p-4">
                        <p class="font-semibold text-slate-800">Backup first</p>
                        <p class="mt-1">Always make a fresh backup before restoring an older snapshot.</p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-white p-4">
                        <p class="font-semibold text-slate-800">Storage location</p>
                        <p class="mt-1">Backups are saved in the local storage disk under <code>storage/app/backups</code>.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
