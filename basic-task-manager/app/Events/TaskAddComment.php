<?php

namespace App\Events;

use App\Models\User;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;

class TaskAddComment implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    
    public function broadcastOn()
    {
        return new Channel('task.' . $this->comment->task_id);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function broadcastAs()
    {
        return 'task.addComment';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {        
        $task = Task::findOrFail($this->comment->task_id);
        $user = User::findOrFail($this->comment->user_id);
        return [
            'id' => $this->comment->id,
            'message' => $this->comment->message,
            'user_id' => $this->comment->user_id,
            'user_name' => $user->name,
            'task_id' => $this->comment->task_id,
            'task_title' => $task->title,
            'created_at' => $this->comment->created_at->toDateTimeString(),
        ];
    }
}
