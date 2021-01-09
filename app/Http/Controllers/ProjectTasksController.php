<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProjectTasksController extends Controller
{
    /**
     * @param Project $project
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

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
     * @throws AuthorizationException
     */
    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $project);

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
