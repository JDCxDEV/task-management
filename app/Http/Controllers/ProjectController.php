<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return response()->json([
            'projects' => $this->formatData($projects)
        ]);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::create($request->all());

        return response()->json(['message' => 'New Project created successfully']);
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project->update($request->all());

        return response()->json(['message' => 'Project updated successfully']);
    }

    /**
     * Fetch tasks belonging to a specific project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasks(Project $project)
    {
        $tasks = $project->tasks()->orderBy('priority')->get();
        return response()->json([
            'tasks' => $tasks
        ]);
    }


    public function updateTaskOrder($projectId, Request $request)
    {
        $request->validate([
            'tasks' => 'required|array',
        ]);

        $tasks = $request->input('tasks');

        $project = Project::findOrFail($projectId);

        foreach ($tasks as $index => $taskData) {
            $project->tasks()->where('id', $taskData['id'])->update(['priority' => $index]);
        }

        return response()->json(['message' => 'Task order updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $project
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Product::withTrashed()->findOrFail($id);
        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $item = Product::withTrashed()->findOrFail($id);
        $item->unarchive();

        return response()->json([
            'message' => "You have successfully restored {$item->renderName()}",
        ]);
    }

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */
    protected function formatData($items)
    {
        $result = [];

        foreach($items as $item) {
            $data = $this->formatItem($item);
            array_push($result, $data);
        }

        return $result;
    }

    /**
     * Build array data
     * 
     * @return array
     */
    protected function formatItem($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'created_at' => $item->renderDate(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }
}
