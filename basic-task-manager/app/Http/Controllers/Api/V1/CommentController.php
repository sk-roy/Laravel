<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService) 
    {
        $this->commentService = $commentService;
    }

    public function index() 
    {
        try {
            $comments = $this->commentService->getAll();
            return response()->json([
                'status'=> 200,
                'tasks'=> $comments,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }

    }

    public function getAllOfUser() // user_id
    {
        try {
            $comments = $this->commentService->getAllOfUser(Auth::id());
            return response()->json([
                'status'=> 200,
                'comments'=> $comments,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function getAllOfTask($taskId) // task_id
    {
        try {
            $comments = $this->commentService->getAllOfTask($taskId);
            return response()->json([
                'status'=> 200,
                'comments'=> $comments,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function getComment($id)  // message_id
    {
        $comment = $this->commentService->getComment($id);
        return response()->json([
            'status'=> 200,
            'comment'=> $comment,
        ]);
    }

    public function store(Request $request) // message, task_id
    {
        try {
            if (empty($request->input('message'))) {
                return response()->json([
                    'message' => 'Empty comment.',
                ]);
            }

            $comment = $this->commentService->create(
                $request->input('message'), 
                Auth::id(), 
                $request->input('task_id')
            );
            
            return response()->json([
                'message' => 'Comment created successfully.',
                'comment' => $comment,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function update(Request $request, $commentId)
    {
        try {
            if (empty($request->input('message'))) {
                return response()->json([
                    'message' => 'Empty comment.',
                ]);
            }

            $comment = $this->commentService->update(
                $commentId,
                $request->input('message'), 
                Auth::id(), 
                $request->input('task_id')
            );
                
            return response()->json([
                'message' => 'Comment updated successfully.',
                'comment' => $comment,
            ]);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function destroy($commentId)
    {
        try {
            $this->commentService->destroy($commentId);
            return response()->json(['message' => 'Comment deleted successfully.']);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }
}
