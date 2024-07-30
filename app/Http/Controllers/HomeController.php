<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projects;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Projects::all();
        // dd($projects);

        return view('home', compact('projects'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Projects::create($request->all());

        return redirect()->route('home');
    }

    public function edit($id)
    {
        $projects = Projects::all();
        $project = Projects::where('project_id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Project retrieved successfully',
            'data' => [
                'project' => $project
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Projects::find($id)->update($request->all());

        return redirect()->route('edit');
    }

    public function delete($id)
    {
        Projects::where('project_id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
    }
}
