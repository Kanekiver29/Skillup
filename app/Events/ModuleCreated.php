<?php

namespace App\Events;

use App\Models\Module;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModuleCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function broadcastOn()
    {
        return new Channel('modules');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->module->id,
            'title' => $this->module->title,
            'course_id' => $this->module->course_id,
            'slug' => $this->module->slug,
            'created_at' => $this->module->created_at?->toDateTimeString(),
        ];
    }
}
