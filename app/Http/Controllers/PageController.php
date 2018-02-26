<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Project;
use Illuminate\Http\Request;
use Auth;

class PageController extends Controller
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
    public function index(Request $request, $project_id)
    {
        return view('page.list' , ['projectId' => $project_id]);
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $slug)
    {
        $page = Pages::find($slug);
        if(empty($page)) {
            abort(404, 'Page not found');
        }
        return view('page.view' , ['page' => $page]);
    }

    public function getList(Request $request, $projectId)
    {
        $project = Auth::user()->projects()->where('id', $projectId)->first();
        if(empty($project)) {
            abort(404, "Project not found");
        }
        return $project->pages()->get();
    }

    public function savePage(Request $request)
    {
        $currentPage = $request->get('currentPage');
        $projectId = $request->get('projectId');
        if(empty($currentPage)) {
            abort(500, "Data not found");
        }
        /**
         * @var Pages $page
         */
        if(empty($currentPage['id'])) {
            $page = new Pages();
            $page->setAttribute('user_id', Auth::user()->id);
            $page->setAttribute('project_id', $projectId);//@todo checking project allow please
        } else {
            $page = Pages::find($currentPage['id']);

            if(empty($page) || $page->project->user_id !== Auth::user()->id) {
                abort(404, "Page not found or you haven't access");
            }
        }

        $page->fill([
            'content' => $currentPage['content'],
            'title' => $currentPage['title'],
            'parent_id' => $currentPage['parent_id'],
        ]);

        if(!$page->save()) {
            abort('500', "Error saving");
        }
        return ['page' => $page];
    }
}
