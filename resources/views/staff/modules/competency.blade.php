@extends('staff.layouts.masters')

@section('title', 'Competency Status')

@section('content')
<div class="container py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Competency Status</h1>
        <p class="mt-1 text-slate-500">Review module coverage and assessment readiness.</p>
    </div>

    <div class="bg-white border rounded overflow-hidden">
        @if($modules->isEmpty())
            <p class="p-6 text-slate-500">No competency modules are available.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="p-4 font-semibold">Module</th>
                            <th class="p-4 font-semibold">Course</th>
                            <th class="p-4 font-semibold">Assessment coverage</th>
                            <th class="p-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $module)
                            <tr class="border-b last:border-b-0">
                                <td class="p-4 font-medium">{{ $module->title }}</td>
                                <td class="p-4 text-slate-600">{{ $module->course?->title ?? 'Unassigned' }}</td>
                                <td class="p-4">{{ $module->quizzes_count ?? 0 }} assessment(s)</td>
                                <td class="p-4 {{ ($module->quizzes_count ?? 0) > 0 ? 'text-emerald-600' : 'text-amber-600' }}">
                                    {{ ($module->quizzes_count ?? 0) > 0 ? 'Assessment ready' : 'Needs assessment' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
