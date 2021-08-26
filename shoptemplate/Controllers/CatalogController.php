<?php

namespace App\Http\Controllers;

use App\FastAdminPanel\Helpers\Lang;
use App\FastAdminPanel\Helpers\Single;
use Illuminate\Http\Request;
use DB;

class CatalogController extends Controller
{
	public function view ($slug) {
	    $producttable = 'product_'.Lang::get();
        $filtervaluetable = 'filter_fields_'.Lang::get();
        $filtergrouptable = 'filters_'.Lang::get();
        $categorytable = 'category_'.Lang::get();
        $getslug = $slug;
        $slug = explode('/',$slug);

        $category = DB::table($categorytable)
            ->where('slug', $slug[0])
            ->first();

        if (empty($category))
            if(strval($slug[0])[0]=='f'||strval($slug[0])[0]=='p') {
                $category = '';
            } else {
                abort(404);
            }

        $filterprice = NULL;
        foreach($slug as $ss){
            if($ss[0]=='f'&&$ss[1]=='-'){
                $filter[] = substr($ss, 2);
            }
            if(stripos($ss,'price-')!==FALSE){
                $filterprice = explode('-',$ss);
            }
        }

        $filterids = [];
        if (isset($filter)) {
            $filtervalues = DB::table('filter_fields_'.Lang::get())
                ->whereIn('slug',$filter)
                ->get();
            foreach($filtervalues as $fff){
                $filterids [] = $fff->id;
            }
        }

        $page_size = 15;
        $page = (!empty(request()->get('page'))) ? request()->get('page') : 1;

        $products = DB::table($producttable)
            ->select($producttable.'.*')
            ->when($category!='',function($q) use ($category){
                return $q->where('id_category',$category->id);
            })
            ->when(isset($filter),function($q) use ($filterids,$producttable){
                return $q->join(
                    'product_filter_fields',
                    'product_filter_fields.id_product',
                    $producttable.'.id'
                )->whereIn('product_filter_fields.id_filter_fields',$filterids);
            })
            ->where(function($query) use($filterprice){
                $query->when(isset($filterprice), function ($q) use ($filterprice){
                    return $q->where([['sale_price','=',0],['price','>=',$filterprice[1]],['price','<=',$filterprice[2]]])
                        ->orWhere([['sale_price','!=',0],['sale_price','>=',$filterprice[1]],['sale_price','<=',$filterprice[2]]]);
                });
            })
            ->skip(($page - 1) * $page_size)
            ->limit($page_size)
            ->get();

        $topproducts = DB::table($producttable)
            ->select('id','title','slug','image','price','sale_price')
            ->limit(8)
            ->get();

        $filtergroups = DB::table($filtergrouptable)
            ->where('is_filter',1)
            ->get();

        foreach($filtergroups as &$ff){
            $ff->values = DB::table($filtervaluetable)
                ->where('id_filters', $ff->id)
                ->get();
        }

        $count = DB::table('product_' . Lang::get())
            ->when($category!='',function($q) use ($category){
                return $q->where('id_category',$category->id);
            })
            ->when(isset($filter),function($q) use ($filterids,$producttable){
                return $q->join(
                    'product_filter_fields',
                    'product_filter_fields.id_product',
                    $producttable.'.id'
                )->whereIn('product_filter_fields.id',$filterids);
            })
            ->count();

        $pagination = $this->pagination($count, $page_size, $page, '/products/'.$getslug);

	    return view('pages.catalog', [
	        'category' => $category,
	        'products' => $products,
	        'topproducts' => $topproducts,
	        'filtergroups' => $filtergroups,
            'pagination' => $pagination,
            'sluh' => $getslug
		]);
	}

    public function index () {
        $producttable = 'product_'.Lang::get();
        $filtervaluetable = 'filter_fields_'.Lang::get();
        $filtergrouptable = 'filters_'.Lang::get();
        $categorytable = 'category_'.Lang::get();
        $page_size = 15;
        $page = (!empty(request()->get('page'))) ? request()->get('page') : 1;

        $products = DB::table($producttable)
            ->skip(($page - 1) * $page_size)
            ->limit($page_size)
            ->get();


        $count = DB::table($producttable)
            ->count();

        $pagination = $this->pagination($count, $page_size, $page, '/products');

        $topproducts = DB::table($producttable)
            ->select('id','title','slug','image','price','sale_price')
            ->limit(8)
            ->get();

        $filtergroups = DB::table($filtergrouptable)
            ->where('is_filter',1)
            ->get();

        foreach($filtergroups as &$ff){
            $ff->values = DB::table($filtervaluetable)
                ->where('id_filters', $ff->id)
                ->get();
        }

        return view('pages.catalog', [
            'products' => $products,
            'topproducts' => $topproducts,
            'filtergroups' => $filtergroups,
            'pagination' => $pagination
        ]);
    }
}
