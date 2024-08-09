<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::get('/task-form', function () { return view('task_form'); })->name('task-form');

    Route::resource('tasks', TaskController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
