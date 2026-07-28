@extends('layout.Admin.system')

@section('content')
<div class="px-6 py-6">
	<div class="flex items-center justify-between mb-6">
		<div>
			<h1 class="text-2xl font-bold text-slate-900">Staff Management</h1>
			<p class="text-sm text-slate-500">Manage platform staff, transfer roles and demote when necessary.</p>
		</div>
		<div class="flex items-center gap-3">
			<a href="{{ route('admin.staff.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded shadow hover:bg-emerald-500">Create Staff</a>
			<a href="{{ route('admin.staff.register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-500">Register Account</a>
		</div>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
		<div class="p-4 bg-white rounded shadow">
			<p class="text-xs text-gray-500 uppercase">Total Staff</p>
			<p class="text-2xl font-semibold">{{ number_format($totalStaff ?? 0) }}</p>
		</div>

		@foreach($staffByType as $key => $info)
			<div class="p-4 bg-white rounded shadow">
				<p class="text-xs text-gray-500 uppercase">{{ $info['label'] }}</p>
				<p class="text-xl font-semibold">{{ number_format($info['count'] ?? 0) }}</p>
			</div>
		@endforeach
	</div>

	<div class="mb-4 bg-white p-4 rounded shadow">
		<form method="GET" action="{{ route('admin.staff.index') }}" class="flex flex-col md:flex-row md:items-center md:gap-4">
			<div class="flex-1">
				<label class="sr-only">Filter by staff type</label>
				<select name="staff_type" class="w-full md:w-64 border rounded px-3 py-2">
					<option value="">All Staff Types</option>
					@foreach($staffTypes as $key => $type)
						<option value="{{ $key }}" {{ request('staff_type') == $key ? 'selected' : '' }}>{{ $type['label'] }}</option>
					@endforeach
				</select>
			</div>
			<div class="mt-3 md:mt-0">
				<button type="submit" class="px-4 py-2 bg-slate-700 text-white rounded">Filter</button>
				<a href="{{ route('admin.staff.index') }}" class="ml-2 px-4 py-2 border rounded">Reset</a>
			</div>
		</form>
	</div>

	<div class="bg-white rounded shadow overflow-hidden">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
					<th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
				@forelse($staff as $user)
				<tr>
					<td class="px-6 py-4 whitespace-nowrap">
						<div class="flex items-center">
							<div class="h-10 w-10 mr-3 rounded-full bg-gray-100 overflow-hidden">
								@if($user->profile_image)
									<img src="{{ $user->profile_image }}" alt="{{ $user->name }}" class="h-full w-full object-cover"/>
								@else
									<div class="flex items-center justify-center h-full text-gray-400">{{ strtoupper(substr($user->name,0,1)) }}</div>
								@endif
							</div>
							<div>
								<div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
								<div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
							</div>
						</div>
					</td>
					<td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
					<td class="px-6 py-4 text-sm text-gray-700">{{ $staffTypes[$user->staff_type]['label'] ?? '—' }}</td>
					<td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
					<td class="px-6 py-4 text-right text-sm font-medium">
						<a href="{{ route('admin.staff.transfer', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Transfer</a>
						<form action="{{ route('admin.staff.demote', $user) }}" method="POST" class="inline" onsubmit="return confirm('Demote this staff member to student?');">
							@csrf
							@method('DELETE')
							<button type="submit" class="text-red-600 hover:text-red-900">Demote</button>
						</form>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No staff found.</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>

	<div class="mt-4">{{ $staff->links() }}</div>

	<div class="mt-8">
		<h3 class="text-lg font-semibold mb-2">Recent Staff Additions</h3>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
			@foreach($recentStaff as $s)
				<div class="p-3 bg-white rounded shadow">
					<div class="font-medium">{{ $s->name }}</div>
					<div class="text-xs text-gray-500">{{ $s->email }}</div>
				</div>
			@endforeach
		</div>
	</div>
</div>

@endsection
