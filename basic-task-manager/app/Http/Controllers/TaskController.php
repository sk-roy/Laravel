<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Services\TaskService;
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
        return view('dashboard', compact('tasks'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        $this->taskService->create($request);

        return redirect()->route('tasks.form')->with('success', 'Task created successfully.');
    }

    public function edit($id)
    {
        $task = $this->taskService->edit($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);
        $this->taskService->update($request, $id);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy($id)
    {
        $this->taskService->destroy($id);
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function list() {
        $sortColumn = request('sort', 'status');
        $sortDirection = request('direction', 'asc'); 
        $tasks = $this->taskService->list($sortColumn, $sortDirection);
        return view('tasks.list', compact('tasks'));
    }
}
