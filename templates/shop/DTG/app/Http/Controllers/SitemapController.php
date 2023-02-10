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

	public function index() {


		$this->add_url('', '1.0');

		$this->add_url('/about', '1.0');
		$this->add_url('/contacts', '1.0');
		$this->add_url(route('catalog', '', false), '1.0');
		$this->add_url(route('projects', '', false), '1.0');
		$this->add_url(route('blog', '', false), '1.0');
		
		$products_category = DB::table('categories_ru')->select('slug')->get();
		foreach ($products_category as $elm)
			$this->add_url(route('catalog', $elm->slug, false), '0.5');

		$products = DB::table('products_ru')->select('slug')->get();
		foreach ($products as $elm)
			$this->add_url(route('product', $elm->slug, false), '0.5');
		
		$projects = DB::table('projects_ru')->select('slug')->get();
		foreach ($projects as $elm)
			$this->add_url(route('projects', $elm->slug, false), '0.5');
		
		$blog = DB::table('blog_ru')->select('slug')->get();
		foreach ($blog as $elm)
			$this->add_url(route('blog', $elm->slug, false), '0.5');
			
		
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
			'is_multilanguage' 		=> $is_multilanguage && Lang::langs()->count() > 1,
		]; 
	}

}