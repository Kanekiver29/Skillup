@extends('layout.Admin.system')

@section('title', 'Chat - Admin Panel')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.chats.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 mb-3">
                    <i class="fas fa-arrow-left"></i>
                    Back to Messages
                </a>
                <h1 class="text-2xl font-bold text-gray-900">{{ $otherParticipant->name }}</h1>
                <p class="text-gray-600 text-sm">{{ $otherParticipant->email }}</p>
            </div>
            <div class="text-right text-sm text-gray-500">
                <p>Joined {{ $otherParticipant->created_at->format('M d, Y') }}</p>
                <p>Role: <span class="font-semibold text-gray-900">{{ ucfirst($otherParticipant->role ?? 'User') }}</span></p>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="bg-white rounded-lg shadow p-6 mb-4 min-h-96 overflow-y-auto max-h-96 space-y-4">
            @forelse ($messages as $message)
                @include('chats._message', ['message' => $message, 'isOwn' => $message->sender_id === auth()->id()])
            @empty
                <div class="text-center text-gray-500">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>

        <!-- Message Form -->
        <form action="{{ route('admin.chats.store') }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">

            <div>
                <textarea
                    name="body"
                    rows="4"
                    placeholder="Type your message here..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('body') border-red-500 @enderror"
                    required
                ></textarea>
                @error('body')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.chats.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Back
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
