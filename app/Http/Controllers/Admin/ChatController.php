<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of all conversations
     */
    public function index()
    {
        $this->authorizeAdmin();

        $userId = auth()->id();
        $isFullAdmin = (bool) auth()->user()->is_admin;

        // Full admins can see all conversations, staff only see assigned conversations.
        $conversations = Conversation::query()
            ->when(! $isFullAdmin, function ($q) use ($userId) {
                $q->where('staff_id', $userId);
            })
            ->with(['user', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->paginate(15);

        return view('Admin.chats.index', compact('conversations'));
    }

    /**
     * Display a specific conversation
     */
    public function show(Conversation $conversation)
    {
        $this->authorizeAdmin();

        // Staff can only access assigned conversations; full admins can access any.
        if (! auth()->user()->is_admin && $conversation->staff_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $messages = $conversation->messages()->get();
        $otherParticipant = $conversation->getOtherParticipant(auth()->id());

        // Mark messages as read
        $conversation->markAsReadFor(auth()->id());

        return view('Admin.chats.show', compact('conversation', 'messages', 'otherParticipant'));
    }

    /**
     * Store a new message or conversation
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'conversation_id' => 'nullable|exists:conversations,id',
            'user_id' => 'required_without:conversation_id|nullable|exists:users,id',
            'body' => 'required|string|max:5000',
            'subject' => 'nullable|string|max:255',
        ]);

        $staffId = auth()->id();
        $conversationId = $validated['conversation_id'] ?? null;

        // If conversation_id provided, use existing conversation
        if ($conversationId) {
            $conversation = Conversation::findOrFail($conversationId);

            // Staff can only reply to assigned conversations; full admins can reply to any.
            if (! auth()->user()->is_admin && $conversation->staff_id !== $staffId) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Create or find conversation with the user
            $userId = $validated['user_id'] ?? null;

            $conversation = Conversation::firstOrCreate(
                [
                    'user_id' => $userId,
                    'staff_id' => $staffId,
                ],
                [
                    'subject' => $validated['subject'] ?? null,
                ]
            );

            // Update the subject when provided for an existing conversation without one.
            if (! empty($validated['subject']) && empty($conversation->subject)) {
                $conversation->update(['subject' => $validated['subject']]);
            }
        }

        // Create the message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $staffId,
            'body' => $validated['body'],
        ]);

        // Update conversation's last_message_at and unread counts
        $conversation->update([
            'last_message_at' => now(),
            'user_unread_count' => $conversation->user_unread_count + 1,
        ]);

        return redirect()->route('admin.chats.show', $conversation->id)
            ->with('success', 'Message sent successfully.');
    }

    /**
     * Mark a conversation as read
     */
    public function markAsRead(Conversation $conversation)
    {
        $this->authorizeAdmin();

        // Staff can only mark assigned conversations as read; full admins can mark any.
        if (! auth()->user()->is_admin && $conversation->staff_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $conversation->markAsReadFor(auth()->id());

        return back()->with('success', 'Conversation marked as read.');
    }

    /**
     * Get list of active users to start chats with (JSON API)
     */
    public function active()
    {
        $this->authorizeAdmin();

        $users = User::where('role', 'student')
            ->where('id', '!=', auth()->id())
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json(['users' => $users]);
    }

    /**
     * Return unread count + recent messages as JSON for real-time polling
     */
    public function notifications()
    {
        $this->authorizeAdmin();

        $staffId = auth()->id();
        $isFullAdmin = (bool) auth()->user()->is_admin;

        $totalUnread = Conversation::query()
            ->when(! $isFullAdmin, function ($q) use ($staffId) {
                $q->where('staff_id', $staffId);
            })
            ->sum('staff_unread_count');

        $recentMessages = Message::whereHas('conversation', function ($q) use ($staffId, $isFullAdmin) {
                if (! $isFullAdmin) {
                    $q->where('staff_id', $staffId);
                }
            })
            ->where('sender_id', '!=', $staffId)
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

        return response()->json([
            'unread' => $totalUnread,
            'messages' => $recentMessages,
        ]);
    }

    /**
     * Authorize admin/staff access
     */
    private function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
