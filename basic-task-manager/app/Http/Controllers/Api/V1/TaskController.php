<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use App\Models\User;
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
        $tasks = $this->taskService->getAllTask(Auth::id());
        return response()->json([
            'status'=> 200,
            'tasks'=> $tasks,
        ]);
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

        $task = $this->taskService->create($request, Auth::id());
        
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
        $task = $this->taskService->update($request, $id, Auth::id());

        return response()->json(['task' => $task, 'message' => 'Task updated successfully.']);
    }

    public function destroy($id)
    {
        $this->taskService->destroy($id);
        return response()->json(['message' => 'Task deleted successfully.']);
    }

    public function share(Request $request) 
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);      
        } catch (Exception $e) {
            return response()->json(['message' => 'Invalid email']);
        }  
        
        $shareWith = User::where('email', $request->input('email'))->first();
        if (!$shareWith) {            
            return response()->json(['message' => 'User not found']);
        }
        foreach ($request->input('selectedTasks') as $taskId) {
            $this->taskService->share($taskId, $shareWith->id, Auth::id());
        }
        
        return response()->json(['message' => 'Task shared successfully.']);
    }
}
