<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'subject',
        'last_message_at',
        'user_unread_count',
        'staff_unread_count',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the student/user who initiated or is part of the conversation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the staff/admin member of the conversation
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get all messages in this conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message in this conversation
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Mark all messages as read for a specific user
     */
    public function markAsReadFor($userId): void
    {
        $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        // Reset unread count
        if ($userId === $this->user_id) {
            $this->update(['user_unread_count' => 0]);
        } elseif ($userId === $this->staff_id) {
            $this->update(['staff_unread_count' => 0]);
        }
    }

    /**
     * Get the other participant in the conversation
     */
    public function getOtherParticipant($currentUserId): ?User
    {
        return $currentUserId === $this->user_id ? $this->staff : $this->user;
    }

    /**
     * Increment unread count for a user
     */
    public function incrementUnreadFor($userId): void
    {
        if ($userId === $this->user_id) {
            $this->increment('user_unread_count');
        } elseif ($userId === $this->staff_id) {
            $this->increment('staff_unread_count');
        }
    }
}
