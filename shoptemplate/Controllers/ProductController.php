<?php

namespace App\Http\Controllers;

use Digiants\FastAdminPanel\Helpers\Lang;
use Digiants\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
	public function view ($slug) {
	    $producttable = 'product_'.Lang::get();
        $filtervaluetable = 'filter_fields_'.Lang::get();
        $filtergrouptable = 'filters_'.Lang::get();
        $modstable = 'mods_'.Lang::get();


        $product = DB::table($producttable)
            ->where('slug', $slug)
            ->first();

        if (empty($product))
            abort(404);

        $product->testims = DB::table('reviews')
            ->where('id_product',$product->id)
            ->get();

        $product->gallery = !empty($product->gallery) ? json_decode($product->gallery) : [];

        $category = DB::table('category_'.Lang::get())
            ->where('id',$product->id_category)
            ->first();

        $mods = DB::table('product_mods')
            ->join(
                $modstable,
                $modstable.'.id',
                'product_mods.id_mods'
                )
            ->where('product_mods.id_product','=',$product->id)
            ->get();

        $attrs = DB::table('product_filter_fields')
            ->select($filtervaluetable.'.title as filtertitle',$filtergrouptable.'.title as grouptitle')
            ->join(
                $filtervaluetable,
                $filtervaluetable.'.id',
                'product_filter_fields.id_filter_fields'
            )
            ->join(
                $filtergrouptable,
                $filtergrouptable.'.id',
                $filtervaluetable.'.id_filters'
            )
            ->where('product_filter_fields.id_product','=',$product->id)
            ->get();

	    $topproducts = DB::table($producttable)
            ->select('id','title','slug','image','price','sale_price')
            ->limit(8)
            ->get();

	    return view('pages.product', [
	        'product' => $product,
            'topproducts' => $topproducts,
            'mods' => $mods,
            'attrs' => $attrs,
            'category' => $category,
		]);
	}

	public function addtestim(){
	    $testim = $_POST;
	    $testim['status'] = 0;
	    $id = DB::table('reviews')->
        insertGetId($testim);
	    echo($id);
	    die();
    }
}
