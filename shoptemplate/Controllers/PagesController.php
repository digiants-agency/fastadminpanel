<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Helpers\Lang;
use App\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class PagesController extends Controller
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

    public function getadmindata(){
	    $popproducts =  DB::select('SELECT product_ru.title, product_ru.slug, product_ru.image, orders_product.link, COUNT(*) as countorders FROM orders_product INNER JOIN product_ru ON product_ru.slug = orders_product.link GROUP BY orders_product.title  ORDER BY countorders DESC LIMIT 5');
        $thismonth = date("Y-m-00 00:00:00");
        $today = date("Y-m-d 00:00:00");
        $alldata =
        [   'allproducts' => DB::table('product_ru')->count(),
            'productsale' => DB::table('orders_product')->sum('count'),
            'callbackall' => DB::table('callback')->count(),
            'allorders' => DB::table('orders')->count(),
            'orderstoday' => db::table('orders')->where('created_at','>',$today)->count(),
            'ordersmonth' => db::table('orders')->where('created_at','>',$thismonth)->count()
            ];

        $lastweek = date( "Y-m-d", strtotime( "-6 day" ));
        $weekdata = [
            date("Y-m-d") => 0,
            date( "Y-m-d", strtotime( "-1 day" )) => 0,
            date( "Y-m-d", strtotime( "-2 day" )) => 0,
            date( "Y-m-d", strtotime( "-3 day" )) => 0,
            date( "Y-m-d", strtotime( "-4 day" )) => 0,
            date( "Y-m-d", strtotime( "-5 day" )) => 0,
            date( "Y-m-d", strtotime( "-6 day" )) => 0,
        ];




        $orders = DB::table('orders')->where('created_at','>',$lastweek)->get();
        foreach($orders as &$lw){
            $lw->created_at = explode(' ',$lw->created_at)[0];
        }
        foreach($orders as $lw){
            $weekdata[$lw->created_at]++;
        }
        $graph1 = implode(',',$weekdata);

        foreach($weekdata as &$w){
            $w = 0;
        }
        $orders = DB::table('callback')->where('created_at','>',$lastweek)->get();

        foreach($orders as &$lw){
            $lw->created_at = explode(' ',$lw->created_at)[0];
        }
        foreach($orders as $lw){
            $weekdata[$lw->created_at]++;
        }
        $graph2 = implode(',',$weekdata);

        $echodata = [
            'firstblock' => $alldata,
            'popproducts' => $popproducts,
            'graph1' => $graph1,
            'graph2' => $graph2
        ];

        echo(json_encode($echodata));
        die();
    }

}
