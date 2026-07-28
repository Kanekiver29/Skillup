@extends('layout.Admin.system')

@section('title', 'System Logs - SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">System Logs</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">System Logs</span>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                {{-- Download --}}
                @if($logExists)
                    <a href="{{ route('admin.systemlog.download') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-download text-gray-500"></i> Download
                    </a>
                @endif

                {{-- Clear log --}}
                @if($logExists)
                    <form method="POST" action="{{ route('admin.systemlog.clear') }}"
                          onsubmit="return confirm('Clear the entire log file? This cannot be undone.')">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                            <i class="fas fa-trash-alt"></i> Clear Log
                        </button>
                    </form>
                @endif

                <div class="p-3 bg-cyan-100 rounded-lg">
                    <i class="fas fa-scroll text-cyan-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-5 py-4">
                <i class="fas fa-check-circle text-green-500 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-lg px-5 py-4">
                <i class="fas fa-exclamation-circle text-red-500 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Log file meta --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            {{-- File status --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 rounded-lg {{ $logExists ? 'bg-green-100' : 'bg-gray-100' }}">
                    <i class="fas fa-file-alt text-lg {{ $logExists ? 'text-green-600' : 'text-gray-400' }}"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Log File</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $logExists ? 'laravel.log' : 'Not found' }}</p>
                </div>
            </div>

            {{-- File size --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-weight-hanging text-blue-600 text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">File Size</p>
                    <p class="text-sm font-semibold text-gray-800">
                        @if($logExists)
                            @php
                                $kb = round($logSize / 1024, 1);
                                $mb = round($logSize / 1024 / 1024, 2);
                            @endphp
                            {{ $mb >= 1 ? $mb . ' MB' : $kb . ' KB' }}
                        @else
                            —
                        @endif
                    </p>
                </div>
            </div>

            {{-- Total entries --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-list-ol text-purple-600 text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Entries</p>
                    <p class="text-sm font-semibold text-gray-800">{{ number_format($total) }}</p>
                </div>
            </div>

            {{-- Last modified --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Last Modified</p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $lastModified ? $lastModified->diffForHumans() : '—' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Level badge summary --}}
        @if($logExists && $total > 0)
        <div class="flex flex-wrap gap-3 mb-6">
            @php
                $levelConfig = [
                    'emergency' => ['bg-red-700',    'text-white',      'fa-radiation'],
                    'alert'     => ['bg-red-600',    'text-white',      'fa-bell'],
                    'critical'  => ['bg-red-500',    'text-white',      'fa-times-circle'],
                    'error'     => ['bg-red-400',    'text-white',      'fa-exclamation-circle'],
                    'warning'   => ['bg-yellow-400', 'text-yellow-900', 'fa-exclamation-triangle'],
                    'notice'    => ['bg-blue-400',   'text-white',      'fa-info'],
                    'info'      => ['bg-blue-500',   'text-white',      'fa-info-circle'],
                    'debug'     => ['bg-gray-400',   'text-white',      'fa-bug'],
                ];
            @endphp
            @foreach($levelConfig as $lvl => [$bg, $text, $icon])
                @php $count = $levelCounts->get($lvl, 0); @endphp
                @if($count > 0)
                    <a href="{{ request()->fullUrlWithQuery(['level' => $lvl, 'page' => 1]) }}"
                       class="{{ $bg }} {{ $text }} inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold hover:opacity-80 transition {{ $filterLevel === $lvl ? 'ring-2 ring-offset-1 ring-gray-700' : '' }}">
                        <i class="fas {{ $icon }}"></i>
                        {{ ucfirst($lvl) }} <span class="opacity-80">({{ $count }})</span>
                    </a>
                @endif
            @endforeach
            @if($filterLevel !== '')
                <a href="{{ request()->fullUrlWithQuery(['level' => '', 'page' => 1]) }}"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    <i class="fas fa-times"></i> Clear filter
                </a>
            @endif
        </div>
        @endif

        {{-- Search & filter bar --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 mb-6">
            <form method="GET" action="{{ route('admin.systemlog') }}" class="flex flex-wrap gap-3 items-end">
                {{-- Preserve level filter --}}
                @if($filterLevel !== '')
                    <input type="hidden" name="level" value="{{ $filterLevel }}">
                @endif

                <div class="flex-1min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Search message</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fas fa-search text-sm"></i>
                        </span>
                        <input type="text" name="search" value="{{ $filterSearch }}"
                               placeholder="Search log messages…"
                               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 focus:border-transparent outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Level</label>
                    <select name="level"
                            class="py-2 pl-3 pr-8 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-400 outline-none bg-white">
                        <option value="">All levels</option>
                        @foreach(array_keys($levelConfig) as $lvl)
                            <option value="{{ $lvl }}" {{ $filterLevel === $lvl ? 'selected' : '' }}>
                                {{ ucfirst($lvl) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg transition">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.systemlog') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Log table / empty state --}}
        @if(! $logExists)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-16 text-center">
                <i class="fas fa-file-slash text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">No log file found</p>
                <p class="text-gray-400 text-sm mt-1">The Laravel log file does not exist yet. It will be created automatically when events are logged.</p>
            </div>
        @elseif($total === 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-16 text-center">
                <i class="fas fa-check-circle text-5xl text-green-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">No log entries match your filter</p>
                <a href="{{ route('admin.systemlog') }}" class="text-cyan-500 text-sm hover:underline mt-2 inline-block">Clear filters</a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                {{-- Table header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-semibold">{{ ($page - 1) * 100 + 1 }}</span>–<span class="font-semibold">{{ min($page * 100, $total) }}</span> of <span class="font-semibold">{{ number_format($total) }}</span> entries
                        @if($filterLevel || $filterSearch)
                            <span class="ml-2 text-cyan-600">(filtered)</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-400">Newest first</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-3 text-left w-40">Timestamp</th>
                                <th class="px-4 py-3 text-left w-20">Channel</th>
                                <th class="px-4 py-3 text-left w-24">Level</th>
                                <th class="px-4 py-3 text-left">Message</th>
                                <th class="px-4 py-3 text-center w-16">Context</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($paginated as $i => $entry)
                                @php
                                    $lvl = $entry['level'];
                                    $rowColor = match($lvl) {
                                        'emergency', 'alert', 'critical' => 'bg-red-50',
                                        'error'   => 'bg-red-50/60',
                                        'warning' => 'bg-yellow-50',
                                        'notice'  => 'bg-blue-50/40',
                                        'debug'   => 'bg-gray-50/60',
                                        default   => '',
                                    };
                                    [$badgeBg, $badgeText, $badgeIcon] = $levelConfig[$lvl] ?? ['bg-gray-200', 'text-gray-700', 'fa-circle'];
                                @endphp
                                <tr class="{{ $rowColor }} hover:bg-opacity-80 transition-colors">
                                    <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap font-mono">
                                        {{ $entry['timestamp'] }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-600 whitespace-nowrap">
                                        {{ $entry['channel'] }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $badgeBg }} {{ $badgeText }} inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold">
                                            <i class="fas {{ $badgeIcon }} text-[10px]"></i>
                                            {{ ucfirst($lvl) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-800 break-all max-w-lg">
                                        <span class="line-clamp-2">{{ $entry['message'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if(trim($entry['context']) !== '')
                                            <button type="button"
                                                    onclick="toggleContext({{ $i }})"
                                                    class="text-cyan-500 hover:text-cyan-700 transition"
                                                    title="Toggle stack trace">
                                                <i class="fas fa-chevron-down" id="icon-{{ $i }}"></i>
                                            </button>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @if(trim($entry['context']) !== '')
                                    <tr id="context-{{ $i }}" class="hidden {{ $rowColor }}">
                                        <td colspan="5" class="px-6 py-3">
                                            <pre class="text-xs text-gray-600 bg-gray-900/5 rounded p-3 overflow-x-auto whitespace-pre-wrap break-all">{{ trim($entry['context']) }}</pre>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($totalPages > 1)
                    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">Page {{ $page }} of {{ $totalPages }}</p>
                        <div class="flex gap-1">
                            {{-- Prev --}}
                            @if($page > 1)
                                <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </a>
                            @endif

                            @php
                                $start = max(1, $page - 2);
                                $end   = min($totalPages, $page + 2);
                            @endphp

                            @if($start > 1)
                                <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">1</a>
                                @if($start > 2)
                                    <span class="px-2 py-1.5 text-sm text-gray-400">…</span>
                                @endif
                            @endif

                            @for($p = $start; $p <= $end; $p++)
                                <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}"
                                   class="px-3 py-1.5 text-sm border rounded-lg transition
                                          {{ $p === $page ? 'bg-cyan-500 text-white border-cyan-500' : 'border-gray-300 hover:bg-gray-50' }}">
                                    {{ $p }}
                                </a>
                            @endfor

                            @if($end < $totalPages)
                                @if($end < $totalPages - 1)
                                    <span class="px-2 py-1.5 text-sm text-gray-400">…</span>
                                @endif
                                <a href="{{ request()->fullUrlWithQuery(['page' => $totalPages]) }}"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">{{ $totalPages }}</a>
                            @endif

                            {{-- Next --}}
                            @if($page < $totalPages)
                                <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"
                                   class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>

<script>
    function toggleContext(id) {
        const row  = document.getElementById('context-' + id);
        const icon = document.getElementById('icon-' + id);
        const hidden = row.classList.toggle('hidden');
        icon.classList.toggle('fa-chevron-down', hidden);
        icon.classList.toggle('fa-chevron-up', !hidden);
    }
</script>
@endsection
