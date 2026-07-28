@php
    $delay = min(($index ?? 0), 10) * 55;
@endphp

<article
    data-message-id="{{ $message->id }}"
    data-updated-at="{{ $message->updated_at->toIso8601String() }}"
    class="chat-message flex items-end gap-3 {{ $isOwn ? 'justify-end' : 'justify-start' }}"
    style="animation-delay: {{ $delay }}ms"
>
    @unless ($isOwn)
        <div class="chat-avatar shrink-0 bg-white text-slate-900 shadow-sm ring-1 ring-slate-200">
            {{ strtoupper(substr($message->sender->name, 0, 1)) }}
        </div>
    @endunless

    <div class="max-w-[88%] sm:max-w-[72%] {{ $isOwn ? 'items-end' : 'items-start' }} flex flex-col gap-2">
        <div class="flex items-center gap-2 {{ $isOwn ? 'justify-end' : 'justify-start' }}">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                {{ $isOwn ? 'You' : $message->sender->name }}
            </p>
            <time class="text-xs text-slate-400" datetime="{{ $message->created_at->toIso8601String() }}">
                {{ $message->created_at->format('M d, H:i') }}
            </time>
            @if($isOwn && $message->read_at)
                <span class="ml-1 text-xs text-green-500">Read</span>
            @endif
        </div>

        <div class="chat-bubble {{ $isOwn ? 'chat-bubble-own' : 'chat-bubble-other' }}">
            <p class="text-sm leading-6 whitespace-pre-wrap break-words">{{ $message->body }}</p>
        </div>
    </div>

    @if ($isOwn)
        <div class="chat-avatar shrink-0 bg-slate-900 text-white shadow-lg shadow-slate-900/15">
            {{ strtoupper(substr($message->sender->name, 0, 1)) }}
        </div>
    @endif
</article>
