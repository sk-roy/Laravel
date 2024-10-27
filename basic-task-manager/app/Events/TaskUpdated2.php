<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;

class TaskUpdated2 implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    
    public function broadcastOn()
    {
        return new Channel('App.Models.User.' . $this->task->userId);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function broadcastAs()
    {
        return 'task.update';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'message' => $this->task->message
        ];
    }
}
