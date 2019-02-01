<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = request()->validate([
            'title'       => 'required',
            'description' => 'required'
        ]);

        auth()->user()->projects()->create($attributes);

        return redirect('/projects');
    }
}
