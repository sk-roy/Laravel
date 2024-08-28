<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {        
        return $this->fileService->show($request);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        return $this->fileService->store($request);
    }

    public function download(Request $request)
    {        
        return $this->fileService->download($request);
    }

    public function destroy($id)
    {
        return $this->fileService->destroy($id);
    }
}
