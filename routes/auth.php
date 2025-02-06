<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;


Route::middleware(['auth'])->group(function () {
    
    // Tasks Routes
    
    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');

    // Projects Routes
    
    Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('project.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('project.update');
    Route::post('/projects/{id}/archive', [ProjectController::class, 'archive'])->name('project.archive');
    Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])->name('project.restore');
    Route::get('/projects/{project}/tasks', [ProjectController::class, 'tasks'])->name('project.tasks');
    Route::put('/projects/{projectId}/tasks/order', [ProjectController::class, 'updateTaskOrder'])->name('project.task-order');
});