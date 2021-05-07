<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function index($id)
    {
        $groups = Group::all();
        $project = Project::findOrFail($id);
        return view('addgroup', compact('project', 'groups'));
    }

    public function store(Request $request)
    {
        $id = $request->get('project_id');
        $project = Project::find($id);
        $project->groups()->sync($request->get('groups'));
        return back();
    }
}
