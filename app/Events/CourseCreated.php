<?php

namespace App\Events;

use App\Models\Course;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast as ShouldBroadcastContract;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow as ShouldBroadcastNowContract;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;

    /**
     * Create a new event instance.
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * The channel the event should broadcast on.
     */
    public function broadcastOn()
    {
        // public channel for courses updates
        return new Channel('courses');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->course->id,
            'title' => $this->course->title,
            'slug' => $this->course->slug,
            'created_at' => $this->course->created_at?->toDateTimeString(),
        ];
    }
}
