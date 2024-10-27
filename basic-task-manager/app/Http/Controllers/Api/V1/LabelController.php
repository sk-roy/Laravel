<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Task;
use App\Models\TaskLabel;
use App\Http\Controllers\Controller;
use App\Http\Services\API\V1\LabelService;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    protected $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    public function getAll()
    {
        try {          
            $labels = $this->labelService->getAll();

            return response()->json([
                'message' => 'Got all labels',
                'labels' => $labels,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function addLabel(Request $request, $id) 
    {
        $label = $this->labelService->addLabel($request->input('label_id'), $id);
        return response()->json([
            'status'=> 200,
            'message' => 'Label added succesfully',
        ]);
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
