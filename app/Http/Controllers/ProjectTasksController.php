<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProjectTasksController extends Controller
{
    public function store(Project $project): RedirectResponse
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param Task $task
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Project $project, Task $task)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        request()->validate(['body' => 'required']);


        $task->update(
            [
                'body'      => request('body'),
                'completed' => request()->has('completed'), // if the checkbox is not checked there won't be such key!!!
            ]
        );

        return redirect($project->path());
    }
}
