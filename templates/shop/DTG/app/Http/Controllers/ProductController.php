<?php

namespace App\Http\Controllers;

use App\FiltersSlug;
use App\Models\AttributesCounter;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Filter;
use App\Models\Product;
use App\View\Components\Filters\Filters;
use App\View\Components\Filters\Sort;
use Illuminate\Http\Request;
use App\View\Components\Inc\Pagination;
use App\View\Components\Products\Products as ProductsComponent;
use Illuminate\Support\Facades\Auth;
use Lang;
use Single;

class ProductController extends Controller
{
	public function products (Request $r, Category $category_model, Product $product_model, $category_slug, $slug = '') {

		$pagesize = 18;
        $page = $r->get('page', 1);
		
		$category = $category_model->get_category_by_slug($category_slug);

		if (empty($category))
			abort(404);

		$category->parents = $category_model->get_parent_categories_by_id($category->id);

		$checked_filters = new FiltersSlug($slug);
		$count_filters = 0;
		if (isset($checked_filters->filters)){
			$count_filters = $checked_filters->filters->flatten()->count();
		}
		
		$min_price = $product_model->where('id_categories', $category->id)->min('price') ?? 0;
		$max_price = $product_model->where('id_categories', $category->id)->max('price') ?? 1000;

		$pricefrom = $checked_filters->filters['minprice'][0] ?? $min_price;
		$priceto = $checked_filters->filters['maxprice'][0] ?? $max_price;

		$sort = $r->get('sort', 'popular');
		

		$get_products = $product_model->get_products($category->id, $page, $pagesize, $sort, $checked_filters->filters);
		
		
		
		
		$products = $get_products['products'];
		$count = $get_products['count'];
		$id_products = $get_products['id_products'];
		

		
		$filters = $category_model->get_filter_by_category($category->id, new FiltersSlug($slug), $id_products);


		if ($sort != 'popular'){
			$paglink = route('catalog', [$category_slug, $slug, 'sort' => $sort], false);
		} else {
			$paglink = route('catalog', [$category_slug, $slug], false);
		}
		
		if ($r->isMethod('post')){
			
			if ($r->get('is_sort', false))
				$page = 1;

			$products_component = new ProductsComponent(3, $products);
			$pagination_component = new Pagination($count, $pagesize, $page, $paglink, true);
			$filters_component = new Filters($filters, route('catalog', [$category->slug, ''], false), $min_price, $max_price, $pricefrom, $priceto);
			$sort_component = new Sort($sort);

			return $this->response([
				'html'			=> $products_component->render(),
				'pagination'	=> $pagination_component->render(),
				'sort'			=> $sort_component->render(),
				'filters'		=> $filters_component->render(),
				'count_filters'	=> $count_filters,
			]);
		}

		$breadcrumbs = $this->make_breadcrumbs($category_model, $category);

		return view('pages.products.products', [
			'products'		=> $products,
			'filters'		=> $filters,
			'category'		=> $category,
			'sort'			=> $sort,
			'slug'			=> $slug,

			'min_price'		=> $min_price,
			'max_price'		=> $max_price,
			'pricefrom'		=> $pricefrom,
			'priceto'		=> $priceto,
			'count_filters'	=> $count_filters,

			'count'			=> $count,
			'pagesize'		=> $pagesize,
			'page'			=> $page,
			'paglink'		=> $paglink,
			'breadcrumbs'	=> $breadcrumbs,
		]); 
	}

	public function product (Category $category_model, Product $product_model, $slug) {

		$product = $product_model->get_product($slug);
		
		if ($product->related_saved()->count() && Auth::user()){
			if ($product->related_saved()->where('id_users', Auth::user()->id)->count())
			$product->saved = true;
		} else
			$product->saved = false;		

		if (empty($product))
			abort(404);

		$product->category = $category_model->get_category_by_id($product->id_categories);
		$product->category->parents = $category_model->get_parent_categories_by_id($product->id_categories);

		$product->characteristics = $product_model->get_characteristics($product->id);
		$recomended = $product_model->get_recomended($product->id);

		$product->attributes_counter = $product_model->get_attributes_counter($product->id);

		
		$breadcrumbs = $this->make_breadcrumbs($category_model, $product->category);

		$breadcrumbs[] = [
			'link'  => '',
			'title' => $product->title
		];

		$product->reviews = $product_model->get_reviews($product->id);
		$product->reviews_count = $product_model->get_reviews_count($product->id);

		return view('pages.products.product', [
			'product'		=> $product,
			'recomended'	=> $recomended,
			'breadcrumbs'	=> $breadcrumbs,
		]); 
	}

	public function make_breadcrumbs(Category $category_model, $category){

		$s = new Single('Каталог', 10, 1);
		$breadcrumbs = [
			[
				'link'	=> route('catalog', ['', ''], false),
				'title'	=> $s->field('Категории', 'Заголовок', 'text', true, 'Каталог товаров'),
			]
		];

		$breadcrumbs_categories = [];

		foreach($category->parents as $category_parent){
			$breadcrumbs_categories = $category_model->make_parents($breadcrumbs_categories, $category_parent);
		}
		$breadcrumbs_categories = array_reverse($breadcrumbs_categories);
		
		foreach($breadcrumbs_categories as $breadcrumbs_category){
			$breadcrumbs[] = $breadcrumbs_category;
		}
		
		$breadcrumbs[] = [
			'link'  => route('catalog', [$category->slug, ''], false),
			'title' => $category->title,
		];

		return $breadcrumbs;
	}


}