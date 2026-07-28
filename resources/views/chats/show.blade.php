@extends('layout.app')

@section('title', 'Conversation - SkillUp')

@section('content')
<div class="chat-shell py-6 md:py-10">
    <div class="mx-auto max-w-5xl">
        <div class="grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
            <aside data-page-animate class="chat-panel overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <div class="chat-hero relative px-6 py-6 text-white">
                    <div class="relative z-[1]">
                        <a href="{{ route('chats.index') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/80 transition hover:bg-white/15 hover:text-white hover:-translate-y-0.5">
                            <i class="fas fa-arrow-left text-[10px]"></i>
                            Inbox
                        </a>

                        <div class="mt-6 flex items-center gap-4">
                            <div class="chat-avatar-xl bg-white text-slate-900 shadow-lg ring-4 ring-white/20">
                                {{ strtoupper(substr($otherParticipant->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Support contact</p>
                                <h1 class="mt-1 text-2xl font-black tracking-tight">{{ $otherParticipant->name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5 px-6 py-6">
                    <div data-page-animate class="page-delay-1 rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Topic</p>
                        <p class="mt-2 text-sm font-semibold text-slate-800">
                            {{ $conversation->subject ?: 'General support and account assistance' }}
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                        <div data-page-animate class="page-delay-2 rounded-2xl border border-slate-200 px-4 py-4 transition hover:border-sky-200 hover:shadow-md">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Member since</p>
                            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $otherParticipant->created_at->format('M d, Y') }}</p>
                        </div>
                        <div data-page-animate class="page-delay-3 rounded-2xl border border-slate-200 px-4 py-4 transition hover:border-sky-200 hover:shadow-md">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Messages</p>
                            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $messages->count() }} in this thread</p>
                        </div>
                    </div>

                    <p data-page-animate class="page-delay-4 text-sm leading-6 text-slate-500">
                        Keep your replies focused and specific so the support team can resolve issues faster.
                    </p>
                </div>
            </aside>

            <section data-page-animate class="page-delay-1 chat-panel flex min-h-[calc(100vh-10rem)] flex-col overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
                <header class="border-b border-slate-100 px-5 py-5 sm:px-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Conversation</p>
                            <h2 class="mt-1 text-xl font-black tracking-tight text-slate-900">{{ $otherParticipant->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                @if ($conversation->last_message_at)
                                    Last update {{ $conversation->last_message_at->diffForHumans() }}
                                @else
                                    New thread
                                @endif
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-2 self-start rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            <span class="chat-live-dot h-2 w-2 rounded-full bg-emerald-500"></span>
                            Support online
                        </span>
                    </div>
                </header>

                <div id="chat-thread" class="chat-thread flex-1 space-y-5 overflow-y-auto px-5 py-6 sm:px-6 scroll-smooth">
                    @forelse ($messages as $message)
                        @include('chats._message', [
                            'message' => $message,
                            'isOwn' => $message->sender_id === auth()->id(),
                            'index' => $loop->index,
                        ])
                    @empty
                        <div class="chat-empty-state flex h-full min-h-80 items-center justify-center">
                            <div class="max-w-sm text-center text-slate-500">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-slate-100 to-sky-50 text-sky-500">
                                    <i class="fas fa-paper-plane text-2xl"></i>
                                </div>
                                <h3 class="mt-5 text-lg font-bold text-slate-900">Start the conversation</h3>
                                <p class="mt-2 text-sm leading-6">Ask a question, report a problem, or request learning support.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <form action="{{ route('chats.store') }}" method="POST" class="border-t border-slate-100 bg-slate-50/80 px-5 py-5 sm:px-6">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">

                    <label for="body" class="mb-3 block text-sm font-semibold text-slate-700">Reply</label>
                    <textarea
                        id="body"
                        name="body"
                        rows="4"
                        placeholder="Type your message here..."
                        class="chat-input w-full @error('body') border-rose-400 ring-rose-100 @enderror"
                        required
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Responses are saved immediately in this thread.</p>
                        <div class="flex gap-3">
                            <a href="{{ route('chats.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 min-h-0">
                                Back
                            </a>
                            <button type="submit" class="chat-send-btn inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 min-h-0">
                                <i class="fas fa-paper-plane text-xs"></i>
                                Send message
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

@include('partials.page-animate')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thread = document.getElementById('chat-thread');
        const body = document.getElementById('body');

        if (thread) {
            thread.scrollTo({ top: thread.scrollHeight, behavior: 'smooth' });
        }

        if (body) {
            body.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    body.closest('form').requestSubmit();
                }
            });
        }
    });
</script>
@endpush
