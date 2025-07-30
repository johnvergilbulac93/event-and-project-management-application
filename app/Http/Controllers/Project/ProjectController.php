<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectFormRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input("page");
        $limit = $request->input("limit");

        $project = Project::query()
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->withQueryString(); // keep query string during pagination

        return Inertia::render('project/Project', [
            'projects' => $project,
            'filters' => [
                'search' => $search,
            ]
        ]);
    }
    public function create()
    {
        return Inertia::render('project/ProjectForm');
    }
    public function store(ProjectFormRequest $request)
    {
        $project = $request->validated();
        Project::create($project);
        return redirect()->route('project.index')
            ->with('message', 'Successfully saved.');
    }
    public function updateIndex($id)
    {
        return Inertia::render('project/ProjectForm', [
            'project' => Project::findOrFail($id)
        ]);
    }
    public function update(ProjectFormRequest $request, $id)
    {
        Project::whereId($id)->update($request->validated());
        return redirect()->route('project.index')
            ->with('message', 'Successfully updated.');
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }
}
