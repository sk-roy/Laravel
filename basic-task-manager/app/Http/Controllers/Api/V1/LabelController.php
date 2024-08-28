<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use App\Models\TaskLabel;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\LabelService;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    protected $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    public function getLabels(Request $request)
    {
        try {
            $taskId = $request->query('task_id');            
            return $this->labelService->getLabels($taskId);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function addLabel(Request $request) {        
        try {
            $labelId = $request->query('label_id');
            $taskId = $request->query('task_id');
                        
            return $this->labelService->addLabel($labelId, $taskId);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding label", 500);
        }
    }

    public function removeLabel(Request $request) {        
        try {
            $labelId = $request->query('label_id');
            $taskId = $request->query('task_id');
                        
            return $this->labelService->removeLabel($labelId, $taskId);
        } catch (Exception $e) {
            throw new Exception("An error occurred while adding label", 500);
        }
    }
}
