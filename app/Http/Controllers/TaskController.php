<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $lastPriority = (int) Project::getLastPriority($request->project_id);

        $task = Task::create([
            'name' => $request->name,
            'priority' => $lastPriority + 1,
            'project_id' => $request->project_id,
        ]);

        return response()->json(['message' => $request->all()]);
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $task = Task::findOrFail($id);

        return response()->json([
            'id' => $task->id,
            'name' => $task->name,
            'updateUrl' =>$task->renderUpdateUrl()   
        ]);
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer',
        ]);

        return response()->json(['message' => 'Task updated successfully']);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
