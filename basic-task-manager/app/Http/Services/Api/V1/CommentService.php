<?php

namespace App\Http\Services\API\V1;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        // $task = Task::findOrFail($task_id);
        return Comment::get();
    }

    public function getAllOfTask($task_id)
    {
        $task = Task::findOrFail($task_id);
        return $task->comments()->get();
    }

    public function getAllOfUser($userId)
    {
        $user = User::findOrFail($userId);
        return $user->comments()->get();
    }

    public function getComment($id)
    {
        return Comment::findOrFail($id);
    }

    public function create($message, $userId, $taskId)
    {
        try {
            $comment = Comment::create([
                'message' => $message,
                'user_id' => $userId,
                'task_id' => $taskId,
            ]);

            return $comment;
        } catch (Exception $e) {
            throw new Exception("An error occurred while creating the task", 500);
        }
    }

    public function update($commentId, $message, $userId, $taskId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $comment->update([
                'message' => $message,
                'user_id' => $userId,
                'task_id' => $taskId,
            ]);
            return $comment;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Task not found", 404);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating the task", 500);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Task not found", 404);
        } catch (Exception $e) {
            throw new Exception("An error occurred while deleting the task", 500);
        }
    }
}
