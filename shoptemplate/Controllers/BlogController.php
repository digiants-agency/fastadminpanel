<?php

namespace App\Http\Controllers;

use Digiants\FastAdminPanel\Helpers\Lang;
use Digiants\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class BlogController extends Controller
{
	public function view ($slug) {
	    $producttable = 'product_'.Lang::get();
        $blogtable = 'blog_'.Lang::get();

        $article = DB::table($blogtable)
            ->where('slug', $slug)
            ->first();

        $blog = DB::table($blogtable)
            ->limit(3)
            ->get();

        if (empty($article))
            abort(404);


        $topproducts = DB::table($producttable)
            ->select('title','slug','image','price','sale_price')
            ->limit(8)
            ->get();


	    return view('pages.article', [
	        'topproducts' => $topproducts,
	        'article' => $article,
	        'blog' => $blog,
		]);
	}

    public function index () {
	    $blogtable = 'blog_'.Lang::get();
        $page_size = 15;
        $page = (!empty(request()->get('page'))) ? request()->get('page') : 1;

        $blog = DB::table($blogtable)
            ->skip(($page - 1) * $page_size)
            ->limit($page_size)
            ->get();

        $count = DB::table($blogtable)
            ->count();

        $pagination = $this->pagination($count, $page_size, $page, '/blog/');

        return view('pages.blog', [
            'blog' => $blog,
            'pagination' => $pagination
        ]);
    }
}
