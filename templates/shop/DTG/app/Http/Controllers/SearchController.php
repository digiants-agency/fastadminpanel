<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\View\Components\Inc\Pagination;
use App\View\Components\Products\Products as ProductsComponent;

use Lang;

class SearchController extends Controller
{
	public function search (Request $r, Product $product_model) {

		$value = $r->get('s');

		$pagesize = 24;
        $page = $r->get('page', 1);
		
		if (!empty($value))
			$products = $product_model->search_by_title($value, $page, $pagesize);
		else 
			$products = [];
		
		$paglink = Lang::link('/search').'?s='.$value;
		
		$count = $product_model->search_count($value);


		if ($r->isMethod('post')){
			
			$products_component = new ProductsComponent(4, $products);
			$pagination_component = new Pagination($count, $pagesize, $page, $paglink);
			
			return $this->response([
				'html'			=> $products_component->render(),
				'pagination'	=> $pagination_component->render(),
			]);
		}

		return view('pages.search', [
			'count'		=> $count,
			'pagesize'	=> $pagesize,
			'page'		=> $page,
			'paglink'	=> $paglink,
			'value'		=> $value,
			'products'	=> $products,
		]); 
	}

	public function search_items(Request $r, Product $product_model){
		$input = $r->get('value');

		$products = $product_model->search_by_title($input);

		$html = '';
		foreach ($products as $product){
			$html .= '<a href="'.route('product', $product->slug, false).'" class="search-form-item extra-text color-text">'.$product->title.'</a>';
		}

		return $this->response([
			'html'	=> $html,
		]);

	}

}