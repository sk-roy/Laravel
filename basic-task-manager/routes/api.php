<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\FileController;
use App\Http\Controllers\Api\V1\LabelController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{id}', [TaskController::class, 'getTask']);
    Route::post('/tasks/create', [TaskController::class, 'store']);
    Route::patch('/tasks/{id}/update', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroy']);
    Route::post('/tasks/share', [TaskController::class, 'share']);

    Route::get('/comments', [CommentController::class, 'index']);
    Route::get('/comments/{id}', [CommentController::class, 'getComment']);
    Route::get('/comments/user', [CommentController::class, 'getAllOfUser']);
    Route::get('/comments/task/{id}', [CommentController::class, 'getAllOfTask']);
    Route::post('/comments/create', [CommentController::class, 'store']);
    Route::patch('/comments/{id}/update', [CommentController::class, 'update']);
    Route::delete('/comments/{id}/delete', [CommentController::class, 'destroy']);

    Route::post('/files', [FileController::class, 'store']);
    Route::get('/files', [FileController::class, 'index']);
    Route::get('/files/download', [FileController::class, 'download']);
    Route::delete('/files/{id}', [FileController::class, 'destroy']);
    
    Route::get('/labels', [LabelController::class, 'getLabels']);
    Route::post('/labels/add', [LabelController::class, 'addLabel']);
    Route::post('/labels/remove', [LabelController::class, 'removeLabel']);

    Route::post('logout', [AuthController::class, 'logout']);
});