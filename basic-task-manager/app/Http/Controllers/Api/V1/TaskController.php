<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskUpdated;
use App\Events\TaskUpdated2;
use App\Events\TaskDelete;
use App\Http\Controllers\Controller;
use App\Http\Services\API\V1\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request) 
    {
        $tasks = $this->taskService->getAllTask($request, Auth::id());
        return response()->json([
            'status'=> 200,
            'tasks'=> $tasks,
        ]);
    }

    public function getTask($id) 
    {
        $task = $this->taskService->getTask($id);
        return response()->json([
            'status'=> 200,
            'task'=> $task,
        ]);
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
        
        $users = Task::find($task->id)
            ->users()
            ->where('users.id', '!=', Auth::id())
            ->get();
        $task["message"] = Auth::user()->name . " updated the task '" . $task->title . "'.";
        
        Notification::send($users, new TaskUpdated($task));

        foreach ($users as $user) {
            $task["userId"] = $user->id;
            TaskUpdated2::dispatch($task);
        }

        return response()->json(['task' => $task, 'message' => 'Task updated successfully.']);
    }

    public function destroy($id)
    {
        try {            
            $task = Task::findOrFail($id);

            $users = Task::find($task->id)
                ->users()
                ->where('users.id', '!=', Auth::id())
                ->get();

            if ($users) {
                $task["message"] = Auth::user()->name . " deleted the task '" . $task->title . "'.";
                
                Notification::send($users, new TaskUpdated($task));
                
                foreach ($users as $user) {
                    $task["userId"] = $user->id;
                    TaskUpdated2::dispatch($task);
                }
            }
            $task = $this->taskService->destroy($id);
                
            return response()->json(['message' => 'Task deleted successfully.']);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
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
