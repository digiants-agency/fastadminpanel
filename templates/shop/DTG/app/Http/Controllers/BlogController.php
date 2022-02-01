<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\View\Components\Blog\Blog as BlogComponent;
use App\View\Components\Inc\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Lang;

class BlogController extends Controller
{
	public function blog (Request $r, Blog $blog_model) {

        $page = $r->get('page', 1);
		$pagesize = 9;
		
		$articles = $blog_model->get_blog($page, $pagesize);

		$paglink = route('blog', '', false);
		$count = $blog_model->count();

		if ($r->isMethod('post')){
			
			$blog_component = new BlogComponent($articles);
			$pagination_component = new Pagination($count, $pagesize, $page, $paglink);
			
			return $this->response([
				'html'			=> $blog_component->render(),
				'pagination'	=> $pagination_component->render(),
			]);
		}

		return view('pages.blog.blog', [
			'articles'	=> $articles,

			'count'		=> $count,
			'pagesize'	=> $pagesize,
			'page'		=> $page,
			'paglink'	=> $paglink,
		]); 
	}

	public function article(Blog $blog_model, $slug) {

		$article = $blog_model->get_article($slug);

		if (empty($article))
			abort(404);

		$read_more = $blog_model->get_read_more($article->id);

		return view('pages.blog.article',[
			'article'	=> $article,
			'read_more'	=> $read_more,
		]);
	}

}