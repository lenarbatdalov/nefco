<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Task/Index', [
            'tasks' => Task::where('user_id', auth()->user()->id)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create([
            'text' => $request->text,
            'project_id' => $request->project_id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('project.show', $request->project_id);
    }

    public function show(Request $request, $id): Response
    {
        return Inertia::render('Task/Show', [
            'task' => Task::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $task = Task::findOrFail($id);
        $task->text = $request->text ?? $task->text;
        $task->status = $request->status ?? $task->status;
        $task->is_completed = $request->is_completed ?? $task->is_completed;
        $task->save();

        return redirect()->route('project.show', $task->project_id);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $task = Task::findOrFail($id);

        $project_id = $task->project_id;

        $task->delete();

        return redirect()->route('project.show', $project_id);
    }
}
