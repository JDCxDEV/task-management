<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;


Route::middleware(['auth'])->group(function () {
    
    // Tasks Routes
    
    Route::get('/tasks', [TaskController::class, 'index'])->name('project.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('project.store');
    Route::post('/tasks/{id}/view', [TaskController::class, 'view'])->name('project.view');
    Route::put('/tasks/{project}/update', [TaskController::class, 'update'])->name('project.update');
    Route::post('/tasks/{id}/archive', [TaskController::class, 'archive'])->name('project.archive');
    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('project.restore');

    // Projects Routes
    
    Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('project.store');
    Route::post('/projects/{id}/view', [ProjectController::class, 'view'])->name('project.view');
    Route::put('/projects/{project}/update', [ProjectController::class, 'update'])->name('project.update');
    Route::post('/projects/{id}/archive', [ProjectController::class, 'archive'])->name('project.archive');
    Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])->name('project.restore');
    Route::get('/projects/{project}/tasks', [ProjectController::class, 'tasks'])->name('project.tasks');
    Route::put('/projects/{id}/tasks/order', [ProjectController::class, 'updateTaskOrder'])->name('project.task-order');
});