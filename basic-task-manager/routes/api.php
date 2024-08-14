<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{id}', [TaskController::class, 'getTask']);
    Route::post('/tasks/create', [TaskController::class, 'store']);
    Route::post('/tasks/{id}/update', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);
});