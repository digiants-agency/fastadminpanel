<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use App\Models\StandartPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
	public function index (Blog $blog_model, Project $project_model) {

		$blog = $blog_model->get_main_page_blog();
		$projects = $project_model->get_main_page_projects();

		return view('pages.index', [
			'blog'		=> $blog,
			'projects'	=> $projects,
		]); 
	}

	public function catalog () {

		return view('pages.catalog', [

		]); 
	}

	public function contacts () {

		return view('pages.contacts', [

		]); 
	}

	public function about () {

		return view('pages.about', [

		]); 
	}

	public function thanks () {

		return view('pages.thanks', [

		]);
	}
	
	public function standart (StandartPage $standart_page_model, $slug) {
		
		$page = $standart_page_model->get_by_slug($slug);

		if (empty($page))
			abort(404);

		return view('pages.standart', [
			'page'	=> $page,
		]); 
	}
	

}