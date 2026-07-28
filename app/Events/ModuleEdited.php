<?php

namespace App\Events;

use App\Models\Module;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModuleEdited implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function broadcastOn()
    {
        // presence channel for editors
        return new PresenceChannel('module.' . $this->module->id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->module->id,
            'title' => $this->module->title,
            'description' => $this->module->description,
            'definition' => $this->module->definition,
            'example' => $this->module->example,
            'order' => $this->module->order,
            'updated_at' => $this->module->updated_at?->toDateTimeString(),
        ];
    }
}
