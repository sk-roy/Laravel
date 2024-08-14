<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index() 
    {
        $tasks = $this->taskService->index();
        return response()->json($tasks);
    }

    public function getTask($id) 
    {
        $tasks = $this->taskService->getTask($id);
        return response()->json($tasks);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        $task = $this->taskService->create($request);
        
        return response()->json(['message' => 'Task created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);
        $task = $this->taskService->update($request, $id);

        return response()->json(['task' => $task, 'success' => 'Task updated successfully.'], 401);
    }

    public function destroy($id)
    {
        $this->taskService->destroy($id);
        return response()->json(['message' => 'Task deleted successfully.']);
    }
}
