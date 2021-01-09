<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $projects = auth()->user()->projects ?? null;

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Project|Application|RedirectResponse|Redirector
     */
    public function store()
    {
        $attributes = request()->validate(
            [
                'title'       => ['required'],
                'description' => ['required'],
                'notes'       => ['min:3'],
            ]
        );

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());

    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return View
     * @throws AuthorizationException
     */
    public function show(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update(['notes' => request('notes')]);

        return redirect($project->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
