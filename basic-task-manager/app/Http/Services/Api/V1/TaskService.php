<?php

namespace App\Http\Services\Api\V1;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllTask($userId)
    {
        $user = User::findOrFail($userId);
        return $user->tasks()->get();
    }

    public function getTask($id)
    {
        $task = Task::findOrFail($id);
        $files = $task->files()->get();
        $task['files'] = $files;
        $labels = $task->labels()->get();
        $task['labels'] = $labels;
        $comments = $task->comments()->get();

        foreach($comments as $comment) {
            $comment['name'] = User::find($comment['user_id'])->name;
        }
        $task['comments'] = $comments;
        return $task;
    }

    public function create(Request $request, $userId)
    {
        try {
            $task = Task::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'due_date' => $request->input('due_date'),
                'status' => $request->input('status'),
                'created_by' => $userId,
            ]);

            $task->users()->attach($userId);
        } catch (Exception $e) {
            throw new Exception("An error occurred while creating the task", 500);
        }
    }

    public function update(Request $request, $id, $userId)
    {
        try {
            $task = Task::findOrFail($id);
            $task->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'due_date' => $request->input('due_date'),
                'status' => $request->input('status'),
                'updated_by' => $userId,
            ]);
            return $task;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Task not found", 404);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating the task", 500);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Task not found", 404);
        } catch (Exception $e) {
            throw new Exception("An error occurred while deleting the task", 500);
        }
    }

    public function share($task_id, $shared_with, $shared_by)
    {
        try {            
            UserTask::create([
                'user_id' => $shared_with,
                'task_id' => $task_id,
                'shared_by' => $shared_by,
            ]);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Task not found", 404);
        } catch (Exception $e) {
            throw new Exception("An error occurred while updating the task", 500);
        }
    }
}
