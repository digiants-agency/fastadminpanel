<?php

namespace App\Http\Controllers;

use Digiants\FastAdminPanel\Helpers\Lang;
use Digiants\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{

    public function index(){

        $req = $_GET['s'];

        $productstable = 'product_'.Lang::get();

        $products = DB::table($productstable)
            ->where('title','LIKE',"%{$req}%")
            ->get();

        return view('pages.search', [
            'products' => $products
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
