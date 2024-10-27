<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('dashboard');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks/create', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit/', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/list', [TaskController::class, 'list'])->name('tasks.list');
    Route::view('/tasks/form', 'form')->name('tasks.form');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
