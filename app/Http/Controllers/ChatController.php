<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the user's conversations
     */
    public function index(Request $request)
    {
        $conversations = Conversation::where('user_id', auth()->id())
            ->with(['staff', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $selectedConversation = null;
        $messages = collect();
        $otherParticipant = null;

        if ($conversations->isNotEmpty()) {
            $selectedConversation = $conversations->firstWhere('id', $request->query('conversation')) ?? $conversations->first();

            if ($selectedConversation) {
                $selectedConversation->load('messages.sender');
                $messages = $selectedConversation->messages;
                $otherParticipant = $selectedConversation->getOtherParticipant(auth()->id());
                $selectedConversation->markAsReadFor(auth()->id());
            }
        }

        return view('chats.index', compact('conversations', 'selectedConversation', 'messages', 'otherParticipant'));
    }

    /**
     * Display a specific conversation
     */
    public function show(Conversation $conversation)
    {
        // Authorize: user can only see their own conversations
        if ($conversation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $messages = $conversation->messages()->get();
        $otherParticipant = $conversation->getOtherParticipant(auth()->id());

        // Mark messages as read
        $conversation->markAsReadFor(auth()->id());

        return view('chats.show', compact('conversation', 'messages', 'otherParticipant'));
    }

    /**
     * Store a new message or conversation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'conversation_id' => 'nullable|exists:conversations,id',
            'staff_id' => 'required_without:conversation_id|nullable|exists:users,id',
            'body' => 'required|string|max:5000',
        ]);

        $userId = auth()->id();
        $conversationId = $validated['conversation_id'] ?? null;

        // If conversation_id provided, use existing conversation
        if ($conversationId) {
            $conversation = Conversation::findOrFail($conversationId);

            // Verify user has access to this conversation
            if ($conversation->user_id !== $userId) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Create or find conversation with the staff member
            $staffId = $validated['staff_id'] ?? null;

            // Verify staff_id is a valid staff/admin user
            $staffUser = User::findOrFail($staffId);
            if (!$staffUser->hasStaffAccess()) {
                abort(400, 'Can only message staff members or admins.');
            }

            $conversation = Conversation::firstOrCreate(
                [
                    'user_id' => $userId,
                    'staff_id' => $staffId,
                ]
            );
        }

        // Create the message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'body' => $validated['body'],
        ]);

        // Update conversation's last_message_at and unread counts
        $conversation->update([
            'last_message_at' => now(),
            'staff_unread_count' => $conversation->staff_unread_count + 1,
        ]);

        return redirect()->route('chats.index', ['conversation' => $conversation->id])
            ->with('success', 'Message sent successfully.');
    }

    /**
     * Mark a conversation as read
     */
    public function markAsRead(Conversation $conversation)
    {
        // Authorize: user can only mark their own conversations as read
        if ($conversation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $conversation->markAsReadFor(auth()->id());

        return back()->with('success', 'Conversation marked as read.');
    }

    /**
     * Return unread count + recent messages as JSON for real-time polling
     */
    public function notifications()
    {
        $data = $this->loadNotificationsData(auth()->id());

        return response()->json([
            'unread' => $data['unread'],
            'messages' => $data['messages'],
        ]);
    }

    public function notificationsPage()
    {
        $data = $this->loadNotificationsData(auth()->id());

        return view('chats.notifications', [
            'totalUnread' => $data['unread'],
            'recentMessages' => $data['messages'],
        ]);
    }

    private function loadNotificationsData(int $userId): array
    {
        $totalUnread = Conversation::where('user_id', $userId)
            ->sum('user_unread_count');

        $recentMessages = Message::whereHas('conversation', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->with(['sender:id,name', 'conversation:id,subject'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'body' => \Illuminate\Support\Str::limit($m->body, 60),
                'sender' => $m->sender->name ?? 'Unknown',
                'conversation_id' => $m->conversation_id,
                'time' => $m->created_at->diffForHumans(),
            ]);

        return [
            'unread' => $totalUnread,
            'messages' => $recentMessages,
        ];
    }
}
