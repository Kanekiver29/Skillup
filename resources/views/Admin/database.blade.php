@extends('layout.Admin.system')

@section('title', 'Database - SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
	<div class="bg-white border-b border-gray-200 mb-8">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
			<div>
				<h1 class="text-3xl font-bold text-gray-900">Database</h1>
				<nav class="text-sm text-gray-500 mt-1">
					<a href="{{ route('admin.dashboard') }}" class="hover:text-cyan-600">Dashboard</a>
					<span class="mx-2">/</span>
					<span class="text-gray-700 font-medium">Database</span>
				</nav>
			</div>
			<div class="text-sm text-gray-600 bg-cyan-50 border border-cyan-100 rounded-lg px-4 py-3">
				<p class="font-medium text-cyan-700">Last sync: {{ $lastUpdated->format('M d, Y h:i A') }}</p>
				<p class="text-cyan-600">Connection: {{ strtoupper($connection) }} ({{ strtoupper($driver) }})</p>
			</div>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 space-y-6">
		@if(!$connectionStatus)
			<div class="bg-red-50 border border-red-200 rounded-lg p-5">
				<div class="flex items-start gap-3">
					<i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
					<div>
						<h2 class="text-base font-semibold text-red-800">Database connection failed</h2>
						<p class="text-sm text-red-700 mt-1">{{ $connectionError }}</p>
					</div>
				</div>
			</div>
		@endif

		<section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
			<article class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
				<div class="flex items-center justify-between mb-3">
					<p class="text-sm text-gray-500">Database Name</p>
					<i class="fas fa-database text-cyan-600"></i>
				</div>
				<p class="text-xl font-bold text-gray-900 break-all">{{ $databaseName }}</p>
				<p class="text-xs text-gray-500 mt-1">Current schema in use</p>
			</article>

			<article class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
				<div class="flex items-center justify-between mb-3">
					<p class="text-sm text-gray-500">Total Tables</p>
					<i class="fas fa-table text-blue-600"></i>
				</div>
				<p class="text-3xl font-bold text-gray-900">{{ number_format($totalTables) }}</p>
				<p class="text-xs text-gray-500 mt-1">Managed records containers</p>
			</article>

			<article class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
				<div class="flex items-center justify-between mb-3">
					<p class="text-sm text-gray-500">Estimated Rows</p>
					<i class="fas fa-stream text-emerald-600"></i>
				</div>
				<p class="text-3xl font-bold text-gray-900">{{ number_format($totalRows) }}</p>
				<p class="text-xs text-gray-500 mt-1">Approximate table rows</p>
			</article>

			<article class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
				<div class="flex items-center justify-between mb-3">
					<p class="text-sm text-gray-500">Total Size</p>
					<i class="fas fa-hdd text-purple-600"></i>
				</div>
				<p class="text-3xl font-bold text-gray-900">{{ number_format($totalSizeMb, 2) }} MB</p>
				<p class="text-xs text-gray-500 mt-1">Data + indexes</p>
			</article>
		</section>

		<section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
				<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
					<div>
						<h2 class="text-lg font-semibold text-gray-900">Table Overview</h2>
						<p class="text-sm text-gray-500">Sorted by total size (descending)</p>
					</div>
					<span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $connectionStatus ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
						{{ $connectionStatus ? 'Connected' : 'Disconnected' }}
					</span>
				</div>

				<div class="overflow-x-auto">
					<table class="min-w-full divide-y divide-gray-200 text-sm">
						<thead class="bg-gray-50">
							<tr>
								<th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wide">Table</th>
								<th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wide">Engine</th>
								<th class="px-6 py-3 text-right font-semibold text-gray-600 uppercase tracking-wide">Rows</th>
								<th class="px-6 py-3 text-right font-semibold text-gray-600 uppercase tracking-wide">Size</th>
								<th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wide">Updated</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-100 bg-white">
							@forelse($tableStats as $table)
								<tr class="hover:bg-gray-50">
									<td class="px-6 py-3 font-medium text-gray-900">{{ $table['name'] }}</td>
									<td class="px-6 py-3 text-gray-600">{{ $table['engine'] }}</td>
									<td class="px-6 py-3 text-right text-gray-700">{{ number_format($table['rows']) }}</td>
									<td class="px-6 py-3 text-right text-gray-700">{{ number_format($table['size_mb'], 2) }} MB</td>
									<td class="px-6 py-3 text-gray-600">
										{{ $table['updated_at'] ? \Illuminate\Support\Carbon::parse($table['updated_at'])->format('M d, Y h:i A') : 'N/A' }}
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5" class="px-6 py-8 text-center text-gray-500">No table data available for this connection.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>

			<div class="space-y-6">
				<div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6">
					<h3 class="text-base font-semibold text-gray-900 mb-3">Storage Health</h3>
					@php
						$usageState = $totalSizeMb < 256 ? 'Healthy' : ($totalSizeMb < 1024 ? 'Watch' : 'High');
						$usageClass = $usageState === 'Healthy'
							? 'bg-green-100 text-green-700'
							: ($usageState === 'Watch' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
					@endphp
					<div class="flex items-center justify-between mb-4">
						<span class="text-sm text-gray-600">Current status</span>
						<span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $usageClass }}">{{ $usageState }}</span>
					</div>
					<div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
						<div class="h-2.5 rounded-full {{ $usageState === 'Healthy' ? 'bg-green-500' : ($usageState === 'Watch' ? 'bg-yellow-500' : 'bg-red-500') }}"
							 style="width: {{ min(100, max(6, ($totalSizeMb / 2048) * 100)) }}%"></div>
					</div>
					<p class="text-xs text-gray-500">Reference scale: 2GB target threshold for this meter.</p>
				</div>

				<div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6">
					<h3 class="text-base font-semibold text-gray-900 mb-3">Maintenance Checklist</h3>
					<ul class="space-y-2 text-sm text-gray-600">
						<li class="flex items-start gap-2"><i class="fas fa-check-circle text-cyan-600 mt-1"></i><span>Run regular backups before deploys.</span></li>
						<li class="flex items-start gap-2"><i class="fas fa-check-circle text-cyan-600 mt-1"></i><span>Review tables with high row growth weekly.</span></li>
						<li class="flex items-start gap-2"><i class="fas fa-check-circle text-cyan-600 mt-1"></i><span>Monitor failed jobs and stale sessions.</span></li>
						<li class="flex items-start gap-2"><i class="fas fa-check-circle text-cyan-600 mt-1"></i><span>Archive historical analytics records monthly.</span></li>
					</ul>
				</div>
			</div>
		</section>

		<section class="bg-linear-to-r from-slate-800 to-slate-700 rounded-xl p-6 text-white shadow-sm">
			<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
				<div>
					<h2 class="text-lg font-semibold">Backup and Recovery Readiness</h2>
					<p class="text-slate-200 text-sm mt-1">Use automated backups plus migration logs to reduce downtime risk.</p>
				</div>
				<div class="flex items-center gap-3">
					<button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white text-slate-800 text-sm font-medium cursor-not-allowed opacity-80" disabled>
						<i class="fas fa-download"></i>
						Backup (coming soon)
					</button>
					<a href="{{ route('admin.settings') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-medium transition">
						<i class="fas fa-cog"></i>
						Open Settings
					</a>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection
