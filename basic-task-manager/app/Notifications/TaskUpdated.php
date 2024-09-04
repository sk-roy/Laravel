<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;

class TaskUpdated extends Notification implements ShouldBroadcast
{
    use Queueable, InteractsWithSockets;

    protected $task;
    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'message' => $this->task->message
        ];
    }
    
    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'message' => $this->task->message
        ]);
    }
    
    
    
    // public function broadcastOn()
    // {
    //     return new Channel('User.1');
    // }
    

    // /**
    //  * Get the type of the notification being broadcast.
    //  */
    // public function broadcastType(): string
    // {
    //     return 'broadcast.message';
    // }
}
