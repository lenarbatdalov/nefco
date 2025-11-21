<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Project/Index', [
            'projects' => Project::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Project::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('project.index');
    }

    public function show(Request $request, $id): Response
    {
        $user = auth()->user();
        $state = $request->query('state') ?? 'active';

        $query = Task::where('project_id', $id);

        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        }

        switch ($state) {
            case 'active':
                $query->where('is_completed', false);
                break;
            case 'completed':
                $query->where('is_completed', true);
                break;
        }

        return Inertia::render('Project/Show', [
            'project' => Project::findOrFail($id),
            'tasks'   => $query->get(),
            'currentState' => $state,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->save();

        return redirect()->route('project.index');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $task = Project::findOrFail($id);
        $task->delete();

        return redirect()->route('project.index');
    }
}
