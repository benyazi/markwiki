<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.list');
    }

    public function getList(Request $request)
    {
        $projects = Auth::user()->projects()->get();
        return $projects;
    }

    public function saveProject(Request $request)
    {
        $projectTitle = $request->get('title', null);
        if(empty($projectTitle)) {
            abort(500, 'Title is empty');

        }

        $project = new Project();
        $project->fill([
            'title' => $projectTitle,
            'user_id' => Auth::id()
        ]);
        if(!$project->save()) {
            abort(500, "Error saving project");
        }
        return Auth::user()->projects()->get();
    }

    public function uploadFile(Request $request)
    {
        $projectId = $request->get('projectId');
        $project = Auth::user()->projects()->where('id', $projectId)->first();
        if(empty($project)) {
            abort(404, 'Not found project');
        }
        $files = $request->file('attachments');
        $collection = $request->get('collection', 'default');
        $errors = [];
        foreach ($files as $file) {
            try {
                $project->addMedia($file)->toMediaCollection($collection);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
        return [
            'success' => (count($errors))?false:true,
            'files' => $project->getMediaFiles(),
            'errors' => $errors
        ];
    }
}
