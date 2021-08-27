<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Digiants\FastAdminPanel\Helpers\Lang;

class SitemapController extends Controller
{
	private $domain;
	private $sitemap = [];

	public function __construct()
	{
		$this->domain = env('APP_URL');
	}

	public function index() {


		$this->add_url('', '1.0');

		/* add url like this */

		// $this->add_url('/about', '1.0');
		// $this->add_url('/contacts', '1.0');
		// $this->add_url('/products', '1.0');
		// $this->add_url('/projects', '1.0');
		
		// $products = DB::table('products_en')->select('slug')->get();
		// foreach ($products as $elm)
		// 	$this->add_url('/product/'.$elm->slug, '0.5');
		
		// $products_category = DB::table('category_products_en')->select('slug')->get();
		// foreach ($products_category as $elm)
		// 	$this->add_url('/products/'.$elm->slug, '0.5');

		// $projects = DB::table('projects_en')->select('slug')->get();
		// foreach ($projects as $elm)
		// 	$this->add_url('/project/'.$elm->slug, '0.5');
		
		// $projects_category = DB::table('category_projects_en')->select('slug')->get();
		// foreach ($projects_category as $elm)
		// 	$this->add_url('/projects/'.$elm->slug, '0.5');
			
		
		$response = Response::make(view('pages.sitemap', 
		[
			'sitemap' => $this->sitemap,
		])->render());
		$response->header('Content-Type', 'text/xhtml+xml; charset=utf-8');
		return $response;

	}

	private function add_url($url, $priority, $is_multilanguage = true) {

		$this->sitemap[] = [
			'slug' 					=> $this->domain.$url, 
			'priority' 				=> $priority, 
			'is_multilanguage' 		=> $is_multilanguage && Lang::get_langs()->count() > 1,
		]; 
	}

}