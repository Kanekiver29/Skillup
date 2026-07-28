<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageSentListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(MessageSent $event)
    {
        // The event already broadcasts, but you could add additional logic here,
        // such as logging, notifications, or updating other systems.
        // Example: logger()->info('MessageSent broadcasted', ['message_id' => $event->message->id]);
    }
}
