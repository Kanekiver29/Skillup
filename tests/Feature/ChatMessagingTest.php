<?php

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the chat inbox with a selected conversation and stores replies', function () {
    $user = User::factory()->create(['role' => 'student']);
    $staff = User::factory()->create(['role' => 'staff']);

    $conversation = Conversation::create([
        'user_id' => $user->id,
        'staff_id' => $staff->id,
        'subject' => 'Support request',
        'last_message_at' => now(),
    ]);

    Message::create([
        'conversation_id' => $conversation->id,
        'sender_id' => $staff->id,
        'body' => 'Hello from support',
        'is_read' => true,
    ]);

    $response = $this->actingAs($user)->get(route('chats.index', ['conversation' => $conversation->id]));

    $response->assertOk();
    $response->assertSee('Support request');
    $response->assertSee('Hello from support');
    $response->assertSee(route('chats.store'));

    $replyResponse = $this->actingAs($user)->post(route('chats.store'), [
        'conversation_id' => $conversation->id,
        'body' => 'Reply from student',
    ]);

    $replyResponse->assertRedirect(route('chats.index', ['conversation' => $conversation->id]));

    $this->assertDatabaseHas('messages', [
        'conversation_id' => $conversation->id,
        'sender_id' => $user->id,
        'body' => 'Reply from student',
    ]);
});
