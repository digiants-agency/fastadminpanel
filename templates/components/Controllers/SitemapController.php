<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\FastAdminPanel\Helpers\Lang;

class SitemapController extends Controller
{
	private $domain;
	private $sitemap = [];

	public function __construct()
	{
		$this->domain = env('APP_URL');
	}

	public function index()
	{
		$this->addUrl('', '1.0');

		/* add url like this */

		// $this->addUrl('/about', '1.0');
		// $this->addUrl('/contacts', '1.0');
		// $this->addUrl('/products', '1.0');
		// $this->addUrl('/projects', '1.0');
		
		// $products = DB::table('products_en')->select('slug')->get();
		// foreach ($products as $elm)
		// 	$this->addUrl('/product/'.$elm->slug, '0.5');
		
		// $products_category = DB::table('category_products_en')->select('slug')->get();
		// foreach ($products_category as $elm)
		// 	$this->addUrl('/products/'.$elm->slug, '0.5');

		// $projects = DB::table('projects_en')->select('slug')->get();
		// foreach ($projects as $elm)
		// 	$this->addUrl('/project/'.$elm->slug, '0.5');
		
		// $projects_category = DB::table('category_projects_en')->select('slug')->get();
		// foreach ($projects_category as $elm)
		// 	$this->addUrl('/projects/'.$elm->slug, '0.5');
			
		
		$response = Response::make(view('pages.sitemap', 
		[
			'sitemap' => $this->sitemap,
		])->render());
		$response->header('Content-Type', 'text/xhtml+xml; charset=utf-8');
		return $response;
	}

	private function addUrl($url, $priority, $is_multilanguage = true)
	{
		$this->sitemap[] = [
			'slug' 					=> $this->domain.$url, 
			'priority' 				=> $priority, 
			'is_multilanguage' 		=> $is_multilanguage && Lang::langs()->count() > 1,
		]; 
	}

}