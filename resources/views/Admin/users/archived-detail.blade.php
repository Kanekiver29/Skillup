@extends('layout.Admin.system')

@section('title', 'Archived User - ' . $user->name)

@section('content')
<div class="min-h-screen bg-gray-50">
	<div class="bg-white border-b border-gray-200 mb-8">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
			<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
				<div>
					<h1 class="text-3xl font-bold text-gray-900">Archived User Details</h1>
					<p class="text-gray-600 mt-1">Viewing archived account and course enrollment history.</p>
				</div>
				<a href="{{ route('admin.archive') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
					&larr; Back to Archive
				</a>
			</div>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		@if(session('success'))
			<div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
				{{ session('success') }}
			</div>
		@endif

		<!-- User Info Card -->
		<section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 mb-8">
			<h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div>
					<p class="text-sm text-gray-500">Full Name</p>
					<p class="text-base font-medium text-gray-900">{{ $user->name }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Email</p>
					<p class="text-base font-medium text-gray-900">{{ $user->email }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">LRN</p>
					<p class="text-base font-medium text-gray-900">{{ $user->lrn ?? 'N/A' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Role</p>
					<p class="text-base font-medium text-gray-900">{{ $user->is_admin ? 'Admin' : 'Student' }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Account Created</p>
					<p class="text-base font-medium text-gray-900">{{ $user->created_at->format('M d, Y h:i A') }}</p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Archived At</p>
					<p class="text-base font-medium text-red-600">{{ optional($user->deleted_at)->format('M d, Y h:i A') ?? 'Unknown' }}</p>
				</div>
			</div>

			<!-- Actions -->
			<div class="mt-6 flex flex-wrap gap-3">
				<form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
					@csrf
					<button type="submit" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
						Restore Account
					</button>
				</form>
				<form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" onsubmit="return confirm('Permanently delete this user and all their data? This action cannot be undone.');">
					@csrf
					@method('DELETE')
					<button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
						Delete Permanently
					</button>
				</form>
			</div>
		</section>

		<!-- Course Enrollment History -->
		<section class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
			<div class="px-5 py-4 border-b border-gray-200">
				<h2 class="text-lg font-semibold text-gray-900">Course Enrollment History</h2>
				<p class="text-sm text-gray-500 mt-1">All courses this user was enrolled in before archiving.</p>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Course</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Progress</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Status</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Enrolled At</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Completed At</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-100 bg-white">
						@forelse($enrollments as $enrollment)
							<tr class="hover:bg-gray-50">
								<td class="px-5 py-4">
									<div class="font-medium text-gray-900">
										{{ $enrollment->course->title ?? $enrollment->course->course_title ?? 'Deleted Course' }}
									</div>
									@if($enrollment->course)
										<div class="text-xs text-gray-500">{{ Str::limit($enrollment->course->description, 60) }}</div>
									@endif
								</td>
								<td class="px-5 py-4">
									<div class="flex items-center gap-2">
										<div class="w-24 bg-gray-200 rounded-full h-2">
											<div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
										</div>
										<span class="text-sm text-gray-700">{{ $enrollment->progress ?? 0 }}%</span>
									</div>
								</td>
								<td class="px-5 py-4 text-sm">
									@if($enrollment->completed)
										<span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded font-semibold">Completed</span>
									@else
										<span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded font-semibold">In Progress</span>
									@endif
								</td>
								<td class="px-5 py-4 text-sm text-gray-700">
									{{ $enrollment->created_at->format('M d, Y') }}
								</td>
								<td class="px-5 py-4 text-sm text-gray-700">
									{{ $enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : '—' }}
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="px-5 py-12 text-center text-sm text-gray-500">
									This user had no course enrollments.
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			@if($enrollments->count() > 0)
				<div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
					<div class="flex flex-wrap gap-4 text-sm text-gray-600">
						<span><strong>Total Courses:</strong> {{ $enrollments->count() }}</span>
						<span><strong>Completed:</strong> {{ $enrollments->where('completed', true)->count() }}</span>
						<span><strong>In Progress:</strong> {{ $enrollments->where('completed', false)->count() }}</span>
					</div>
				</div>
			@endif
		</section>
	</div>
</div>
@endsection
