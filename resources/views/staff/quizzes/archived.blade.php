@extends('staff.layouts.masters')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section with Back Navigation -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4 mb-4 sm:mb-0">
                <a href="{{ route('staff.quizzes.list') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-slate-700/50 text-slate-300 hover:bg-slate-600/50 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i>
                    <span>Back to Quizzes</span>
                </a>
                <h1 class="text-3xl sm:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-400 to-rose-400">
                    <i class="fas fa-box-archive mr-3 text-amber-400" aria-hidden="true"></i>Archived Quizzes
                </h1>
            </div>
        </div>

        <!-- Stats Section -->
        @if($quizzes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-br from-slate-700/40 to-slate-800/40 border border-slate-600/40 rounded-lg px-6 py-4 backdrop-blur-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-medium">Archived Quizzes</p>
                            <p class="text-2xl font-bold text-amber-400 mt-1">{{ $quizzes->count() }}</p>
                        </div>
                        <i class="fas fa-box-archive text-amber-400 text-3xl opacity-20" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-700/40 to-slate-800/40 border border-slate-600/40 rounded-lg px-6 py-4 backdrop-blur-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-medium">Modules with Archives</p>
                            <p class="text-2xl font-bold text-sky-400 mt-1">{{ $quizzes->pluck('module.id')->unique()->count() }}</p>
                        </div>
                        <i class="fas fa-layer-group text-sky-400 text-3xl opacity-20" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-700/40 to-slate-800/40 border border-slate-600/40 rounded-lg px-6 py-4 backdrop-blur-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-medium">Last Archived</p>
                            <p class="text-2xl font-bold text-violet-400 mt-1">{{ $quizzes->first()?->archived_at?->diffForHumans() ?? 'N/A' }}</p>
                        </div>
                        <i class="fas fa-clock text-violet-400 text-3xl opacity-20" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        @endif

        <!-- Archived Quizzes Table -->
        <div class="bg-slate-700/30 border border-slate-600/50 rounded-xl overflow-hidden backdrop-blur-md shadow-2xl">
            @if($quizzes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-slate-800/50 to-slate-700/50 border-b border-slate-600/50">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Quiz Title</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Module</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Archived Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Questions</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-600/30">
                            @foreach($quizzes as $quiz)
                                <tr class="hover:bg-slate-600/20 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mr-3 flex-shrink-0">
                                                <i class="fas fa-box-archive text-white text-sm" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">{{ $quiz->title }}</p>
                                                <p class="text-slate-400 text-xs">{{ $quiz->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block bg-slate-600/50 text-slate-300 px-3 py-1 rounded-full text-sm">
                                            {{ $quiz->module?->title ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300 text-sm">
                                        <div>
                                            <p>{{ $quiz->archived_at?->format('M d, Y') ?? 'N/A' }}</p>
                                            <p class="text-slate-500 text-xs">{{ $quiz->archived_at?->diffForHumans() ?? '' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300 text-sm font-medium">
                                        {{ $quiz->quizQuestions->count() }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <form action="{{ route('staff.quizzes.restore', $quiz) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 mr-2" title="Restore this quiz">
                                                <i class="fas fa-undo mr-2" aria-hidden="true"></i>Restore
                                            </button>
                                        </form>
                                        <button type="button" class="inline-flex items-center px-3 py-2 rounded-lg bg-rose-600/20 text-rose-400 font-semibold hover:bg-rose-600/40 transition-all duration-200 delete-archived-trigger" data-quiz-id="{{ $quiz->id }}" data-quiz-title="{{ $quiz->title }}" title="Permanently delete this archived quiz">
                                            <i class="fas fa-trash mr-2" aria-hidden="true"></i>Delete
                                        </button>
                                        <form id="delete-archived-form-{{ $quiz->id }}" action="{{ route('staff.quizzes.destroy', $quiz) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-box-open text-5xl text-slate-500/30" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-300 mb-2">No Archived Quizzes</h3>
                    <p class="text-slate-400">You don't have any archived quizzes yet.</p>
                    <a href="{{ route('staff.quizzes.list') }}" class="inline-block mt-4 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors duration-200">
                        View Active Quizzes
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-archived-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden border border-slate-700/50">
        <div class="bg-gradient-to-r from-rose-600 to-red-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-exclamation-triangle mr-3" aria-hidden="true"></i>
                Permanently Delete Quiz
            </h3>
        </div>
        <div class="px-6 py-4">
            <p class="text-slate-300 mb-2">Are you sure you want to permanently delete the archived quiz:</p>
            <p id="delete-quiz-title-modal" class="font-bold text-white mb-4"></p>
            <p class="text-slate-400 text-sm">This action cannot be undone. All associated questions and attempt data will be permanently removed.</p>
        </div>
        <div class="bg-slate-700/30 px-6 py-4 flex gap-3 justify-end">
            <button type="button" class="px-4 py-2 rounded-lg bg-slate-600 text-white font-medium hover:bg-slate-700 transition-colors duration-200" onclick="closeDeleteModal()">
                Cancel
            </button>
            <button type="button" class="px-4 py-2 rounded-lg bg-gradient-to-r from-rose-600 to-red-600 text-white font-bold hover:from-rose-700 hover:to-red-700 transition-all duration-200" onclick="confirmDeleteArchived()">
                Delete Permanently
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .delete-archived-trigger {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    let currentDeleteId = null;

    document.querySelectorAll('.delete-archived-trigger').forEach(button => {
        button.addEventListener('click', function() {
            currentDeleteId = this.dataset.quizId;
            document.getElementById('delete-quiz-title-modal').textContent = this.dataset.quizTitle;
            document.getElementById('delete-archived-modal').classList.remove('hidden');
        });
    });

    function closeDeleteModal() {
        document.getElementById('delete-archived-modal').classList.add('hidden');
        currentDeleteId = null;
    }

    function confirmDeleteArchived() {
        if (currentDeleteId) {
            document.getElementById('delete-archived-form-' + currentDeleteId).submit();
        }
    }

    // Close modal when clicking outside
    document.getElementById('delete-archived-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush
