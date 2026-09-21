@extends('staff.layouts.masters')

@section('title', 'Assessment Schedule')

@section('content')
<div class="container py-8">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Assessment Schedule</h1>
            <p class="mt-1 text-slate-500">Manage active assessments and their questionnaires.</p>
        </div>
        <a href="{{ route('staff.quizzes.create') }}" class="px-4 py-2 rounded bg-blue-600 text-white">Create assessment</a>
    </div>

    <div class="bg-white border rounded overflow-hidden">
        @if($quizzes->isEmpty())
            <p class="p-6 text-slate-500">No active assessments found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="p-4 font-semibold">Assessment</th>
                            <th class="p-4 font-semibold">Module</th>
                            <th class="p-4 font-semibold">Passing score</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                            <tr class="border-b last:border-b-0">
                                <td class="p-4 font-medium">{{ $quiz->title }}</td>
                                <td class="p-4 text-slate-600">{{ $quiz->module?->title ?? 'Unassigned' }}</td>
                                <td class="p-4">{{ $quiz->passing_score ?? 0 }}%</td>
                                <td class="p-4">{{ $quiz->is_published ? 'Published' : 'Draft' }}</td>
                                <td class="p-4">
                                    <div class="flex gap-3">
                                        <a class="text-blue-600" href="{{ route('staff.quizzes.questionnaire', $quiz) }}">Questions</a>
                                        <a class="text-slate-600" href="{{ route('staff.quizzes.edit', $quiz) }}">Edit</a>
                                    </div>
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
