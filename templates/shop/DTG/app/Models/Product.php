<?php

namespace App\Models;

use App\FiltersSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MultilanguageModel;
use App\Models\Saved\SavedHandler;
use Lang;
use DB;
use Illuminate\Support\Facades\Auth;

class Product extends MultilanguageModel
{
    protected $table = 'products';
    protected $category_model;

    public function __construct(){
        parent::__construct();

        $this->category_model = new Category();
    }

    protected static function booted(){

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', '=' , 1);
        });
    }

    public function related_filter_fields() {
        return $this->belongsToMany(FilterField::class, 'products_filter_fields', 'id_products', 'id_filter_fields');
    }

    public function get_products($category_id, $page = 1, $pagesize = 18 , $sort = 'popular', $filters = null){
        $filter_fields_model = new FilterField();

        $categories_ids = $this->category_model->get_subcategories_by_id($category_id);

        $query = $this->whereIn('id_categories', $categories_ids)
        ->when(isset($filters['minprice']), function($q) use ($filters){
            return $q->where('price', '>=', $filters['minprice']);
        })
        ->when(isset($filters['maxprice']), function($q) use ($filters){
            return $q->where('price', '<=', $filters['maxprice']);
        });

        if (!empty($filters)){

            if ($filters->has('minprice'))
                $filters->forget('minprice');

            if ($filters->has('maxprice'))
                $filters->forget('maxprice');

            if (sizeof($filters)){
                $id_products_filter_fields = $filter_fields_model->get_id_products_filter_fields($filters);

                $query = $query->whereIn('id', $id_products_filter_fields);
            }
        }


        $count = $query->count();

        $sort = $this->get_sort($sort);
        $products = $query->orderBy('is_available', 'DESC')
        ->orderBy($sort[0], $sort[1])
        ->skip(($page - 1) * $pagesize)
        ->limit($pagesize)
        ->get();

        $id_products = $query->select('id')->get()->pluck('id')->all();

        $min_price = $query->min('price');
        $max_price = $query->max('price');

        return [
            'count'         => $count,  
            'products'      => $products,
            'id_products'   => $id_products,
            'min_price'     => $min_price,
            'max_price'     => $max_price,
        ];
    }

    public function get_product($slug){

        if (Auth::user()){

            $product = $this->where('slug', $slug)
            ->with('related_saved')
            ->first();
        } else {
        
            $product = $this->where('slug', $slug)
            ->first();    
        }

        if (!empty($product))
		    $product->gallery = json_decode($product->gallery);

        return $product;
    }

    public function related_saved(){
        return $this->hasMany(SavedHandler::class, 'id_products');
    }

    public function related_characteristics(){
        return $this->hasMany(Characteristic::class, 'id_products');
    }

    public function get_characteristics($id){
        return $this::find($id)
        ->related_characteristics()
        ->get();
    }

    protected function related () {
		return $this->belongsToMany(Product::class, 'products_products', 'id_products', 'id_products_other');
	}
    
    public function get_recomended($id){
        $hash = crc32(url()->current());
        srand($hash);

        $recomended = $this::find($id)
        ->related()
        ->where('is_available', 1)
        ->get();
        
        if (sizeof($recomended) == 0){

            $recomended = $this::get()
            ->where('is_available', 1)
            ->where('id', '!=', $id)
            ->shuffle()
            ->slice(0, 4);
        }

        return $recomended;
    }

    protected function related_reviews(){
        return $this->hasMany(Review::class, 'id_products');
    }

    public function get_reviews($id, $page = 1, $pagesize = 2){
        return $this::find($id)
        ->related_reviews()
        ->skip(($page - 1) * $pagesize)
        ->limit($pagesize)
        ->get();
    }

    public function get_reviews_count($id){
        return $this::find($id)
        ->related_reviews()
        ->count();
    }

    public function search_by_title($title, $page = 1, $pagesize = 5){
        return $this->where('title', 'like', '%'.$title.'%')
        ->orderBy('is_available', 'DESC')
        ->skip(($page - 1) * $pagesize)
        ->limit($pagesize)
        ->get();
    }

    public function search_count($title) {
        if ($title)
            return $this->where('title', 'like', '%'.$title.'%')
            ->count();
        else 
            return 0;
    }

	protected function related_attributes_counter(){
		return $this->belongsToMany(AttributesCounter::class, 'products_attributes_counter', 'id_products', 'id_attributes_counter');
    }

    public function get_attributes_counter($id){
        return $this::find($id)
        ->related_attributes_counter()
        ->where('id_products', $id)
        ->get();

    }

    protected function get_sort($sort_value){
        $sort = [
            'popular'   => [
                'sort', 'DESC'
            ],
            'pricedesc' => [
                'price', 'DESC',
            ],
            'priceasc'  => [
                'price', 'ASC'
            ],
            'titledesc' => [
                'title', 'DESC'
            ],
            'titleasc'  => [
                'title', 'ASC'
            ],
        ];

        return $sort[$sort_value];
    }

}
