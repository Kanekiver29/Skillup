@extends('layout.Admin.system')

@section('title', 'Archive Center - SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
	<div class="bg-white border-b border-gray-200 mb-8">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
			<div>
				<h1 class="text-3xl font-bold text-gray-900">Archive Center</h1>
				<p class="text-gray-600 mt-1">Review archived records and restore items when needed.</p>
			</div>
			<div class="text-sm text-gray-600">
				<span class="font-semibold text-gray-800">Updated:</span>
				{{ now()->format('M d, Y h:i A') }}
			</div>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		@if(session('success'))
			<div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
				{{ session('success') }}
			</div>
		@endif

		@if(session('error'))
			<div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
				{{ session('error') }}
			</div>
		@endif

		<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
			<div class="bg-white rounded-lg border border-gray-200 p-5">
				<p class="text-sm text-gray-500">Archived Users</p>
				<p class="text-3xl font-bold text-red-600 mt-2">{{ $archivedCount }}</p>
			</div>
			<div class="bg-white rounded-lg border border-gray-200 p-5">
				<p class="text-sm text-gray-500">Restorable Routes</p>
				<p class="text-3xl font-bold text-emerald-600 mt-2">{{ $hasRestoreRoute ? 'Enabled' : 'Missing' }}</p>
			</div>
			<div class="bg-white rounded-lg border border-gray-200 p-5">
				<p class="text-sm text-gray-500">Archive Mode</p>
				<p class="text-3xl font-bold text-blue-600 mt-2">{{ $archiveReady ? 'Ready' : 'Setup Needed' }}</p>
			</div>
		</div>

		@if(!$archiveReady)
			<div class="mb-8 rounded-lg border border-amber-200 bg-amber-50 px-5 py-4 text-amber-800">
				<h2 class="font-semibold mb-1">Archive storage is not fully configured</h2>
				<p class="text-sm">To enable real archived-user data, add soft delete support to the users table and User model.</p>
			</div>
		@endif

		<section class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
			<div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
				<h2 class="text-lg font-semibold text-gray-900">Archived Users</h2>
				<a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Back to Users</a>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">User</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Email</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Archived At</th>
							<th class="px-5 py-3 text-right text-xs font-semibold tracking-wider text-gray-600 uppercase">Actions</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-100 bg-white">
						@forelse($archivedUsers as $user)
							<tr class="hover:bg-gray-50">
								<td class="px-5 py-4">
									<div class="font-medium text-gray-900">{{ $user->name }}</div>
									<div class="text-xs text-gray-500">@{{ $user->username ?? 'N/A' }}</div>
								</td>
								<td class="px-5 py-4 text-sm text-gray-700">{{ $user->email }}</td>
								<td class="px-5 py-4 text-sm text-gray-700">
									{{ optional($user->deleted_at)->format('M d, Y h:i A') ?? 'Unknown' }}
								</td>
								<td class="px-5 py-4">
									<div class="flex flex-wrap justify-end gap-2">
										<a href="{{ route('admin.users.archived-detail', $user->id) }}" class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">
											View History
										</a>
										@if($hasRestoreRoute)
											<form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
												@csrf
												<button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
													Restore
												</button>
											</form>
										@else
											<button type="button" class="rounded-md bg-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 cursor-not-allowed" disabled>
												Restore Unavailable
											</button>
										@endif

										@if($hasForceDeleteRoute)
											<form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" onsubmit="return confirm('Permanently delete this user? This action cannot be undone.');">
												@csrf
												@method('DELETE')
												<button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
													Delete Permanently
												</button>
											</form>
										@endif
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="px-5 py-12 text-center text-sm text-gray-500">
									No archived users found.
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			@if(method_exists($archivedUsers, 'hasPages') && $archivedUsers->hasPages())
				<div class="px-5 py-4 border-t border-gray-200">
					{{ $archivedUsers->links() }}
				</div>
			@endif
		</section>
	</div>
</div>
@endsection
