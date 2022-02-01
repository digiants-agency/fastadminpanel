<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\View\Components\Inc\Pagination;
use App\View\Components\Projects\Projects as ProjectComponent;
use Lang;

class ProjectController extends Controller
{
	public function projects (Request $r, Project $project_model) {

		$pagesize = 6;
        $page = $r->get('page', 1);
		
		$projects = $project_model->get_projects($page, $pagesize);

		$paglink = route('projects', '', false);
		$count = $project_model->count();
		
		if ($r->isMethod('post')){
			
			$projects_component = new ProjectComponent($projects);
			$pagination_component = new Pagination($count, $pagesize, $page, $paglink);
			
			return $this->response([
				'html'			=> $projects_component->render(),
				'pagination'	=> $pagination_component->render(),
			]);
		}

		return view('pages.projects.projects', [
			'projects'	=> $projects,

			'count'		=> $count,
			'pagesize'	=> $pagesize,
			'page'		=> $page,
			'paglink'	=> $paglink,
		]); 
	}

	public function project(Project $project_model, $slug) {

		$project = $project_model->get_project($slug);
		
		if (empty($project))
			abort(404);

		return view('pages.projects.project', [
			'project'	=> $project,
		]);
	}

}