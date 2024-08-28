<?php

namespace App\Http\Services\Api\V1;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelService
{
    public function getLabels($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);
            $labels = $task->labels()->get();

            return response()->json([
                'message' => 'Got all labels',
                'labels' => $labels,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function addLabel($labelId, $taskId) {        
        try {            
            TaskLabel::create([
                'user_id' => 1,
                'task_id' => $taskId,
                'label_id' => $labelId,
            ]);

            return response()->json([
                'message' => 'Label added succesfully.',
            ]);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding label", 500);
        }
    }

    public function removeLabel($labelId, $taskId) {        
        try {
            $taskLabel = TaskLabel::where('task_id', $taskId)->where('label_id', $labelId)->firstOrFail();
            $taskLabel->delete();

            return response()->json([
                'message' => 'Label removed succesfully.',
            ]);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding label", 500);
        }
    }
}
