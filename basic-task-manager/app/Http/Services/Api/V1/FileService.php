<?php

namespace App\Http\Services\Api\V1;

use App\Models\File;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileService
{
    public function show(Request $request)
    {
        try {
            $taskId = $request->query('task_id');
            $task = Task::findOrFail($taskId);
            $files = $task->files()->get();

            return response()->json(['files' => $files], 200);
        } catch (Exception $e) {
            Log::error("Error fetching files for user ID " . auth()->id() . ": {$e->getMessage()}");

            return response()->json(['error' => 'Failed to retrieve files. Please try again later.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            $uploadedFile = $request->file('file');
            $taskId = $request->input('task_id');
            $filename = $taskId . '_' . $uploadedFile->getClientOriginalName();

            $path = $uploadedFile->storeAs('uploads/' . $taskId, $filename, 'public');

            $file = File::create([
                'user_id'   => $user->id,
                'task_id'   => $taskId,
                'filename'  => $filename,
                'path'      => $path,
                'mime_type' => $uploadedFile->getClientMimeType(),
                'size'      => $uploadedFile->getSize(),
            ]);

            Log::info("File uploaded successfully by user ID {$user->id} under task {$taskId}: {$filename}");

            return response()->json(['file' => $file, 'message' => 'File uploaded successfully.'], 201);
        } catch (Exception $e) {
            Log::error("File upload failed: {$e->getMessage()}");

            return response()->json(['error' => 'Failed to upload the file. Please try again later.'], 500);
        }
    }

    public function download(Request $request)
    {
        try {            
            $fileId = $request->query('file_id');
            $file = File::where('id', $fileId)->firstOrFail();

            return Storage::disk('public')->download($file->path, $file->filename);
        } catch (Exception $e) {
            Log::error("File download failed for user ID " . auth()->id() . ": {$e->getMessage()}");

            return response()->json(['error' => 'Failed to download the file. Please try again later.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $file = File::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            Storage::disk('public')->delete($file->path);
            $file->delete();

            Log::info("File deleted successfully by user ID " . auth()->id() . ": {$file->filename}");

            return response()->json(['message' => 'File deleted successfully.'], 200);
        } catch (Exception $e) {
            Log::error("File deletion failed for user ID " . auth()->id() . ": {$e->getMessage()}");

            return response()->json(['error' => 'Failed to delete the file. Please try again later.'], 500);
        }
    }
}
