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
        $blog = DB::table($blogtable)
            ->get();

        return view('pages.blog', [
            'blog' => $blog,
        ]);
    }
}
