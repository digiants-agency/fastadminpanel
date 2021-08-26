<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Helpers\Lang;
use App\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{

    public function index(){

        $req = $_GET['s'];

        $productstable = 'product_'.Lang::get();

        $page_size = 15;
        $page = (!empty(request()->get('page'))) ? request()->get('page') : 1;

        $products = DB::table($productstable)
            ->where('title','LIKE',"%{$req}%")
            ->skip(($page - 1) * $page_size)
            ->limit($page_size)
            ->get();

        $count = DB::table($productstable)
            ->where('title','LIKE',"%{$req}%")
            ->count();

        $pagination = $this->pagination($count, $page_size, $page, '/search?s='.$req);

        return view('pages.search', [
            'products' => $products,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxsearch(){
        $req = $_POST['s'];

        $productstable = 'product_'.Lang::get();

        $products = DB::table($productstable)
            ->where('title','LIKE',"%{$req}%")
            ->limit(6)
            ->get();
        $str = '';
        foreach($products as $pp){
            $str.= "<a href='".Lang::link('/'.$pp->slug)."'>{$pp->title}";
        }

        echo($str);
        die();
    }


}
