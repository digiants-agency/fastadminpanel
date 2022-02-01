<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Helpers\Lang;
use App\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class PageController extends Controller
{
	public function index () {
	    $cattable = 'category_'.Lang::get();
	    $producttable = 'product_'.Lang::get();
	    $newstable = 'blog_'.Lang::get();


	    $topcats = DB::table($cattable)->
            select('title','slug','img')
            ->limit(6)
            ->get();

	    $topproducts = DB::table($producttable)
            ->select('id','title','slug','image','price','sale_price')
            ->limit(8)
            ->get();

	    $topnews = DB::table($newstable)
            ->select('title','slug','preview_img','preview','created_at')
            ->limit(3)
            ->get();

	    return view('pages.index', [
            'topcats' => $topcats,
            'topproducts' => $topproducts,
            'topnews' => $topnews,
		]);
	}

	public function contact(){
        return view('pages.contact', []);
    }

	public function about(){
        return view('pages.about', []);
    }

	public function delandpay(){
        return view('pages.delandpay', []);
    }

	public function successorder(){
        return view('pages.successorder', []);
    }

    public function defaultpage($slug){
        $page = DB::table('page_'.Lang::get())->where('slug',$slug)->first();
        if(empty($page)) abort(404);
        return view('pages.default', [
            'page'=>$page
        ]);
    }

}
