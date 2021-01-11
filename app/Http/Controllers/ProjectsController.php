<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    //

    public function index()
    {
        $projects =Project::all();

        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        /*
        //one approach
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'owner_id' => 'required'
        ]);

        Project::create($attributes);*/

        //Second approach:
        /*
         * Let's say user needs to be logged in to create a project
         */
/*        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $attributes['owner_id'] = auth()->id();

        Project::create($attributes);*/

        //Or
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        auth()->user()->projects()->create($attributes);


        return redirect('/projects');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
