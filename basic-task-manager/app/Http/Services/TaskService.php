<?php

namespace App\Http\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createTask($data)
    {
        return Task::create($data);
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        return $task;
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task;
    }

    public function destroyTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }

    public function listTask($sortColumn, $sortDirection)
    {
        $tasks = Task::where('user_id', auth()->id())->orderBy($sortColumn, $sortDirection)->get();
        return $tasks;
    }
}
