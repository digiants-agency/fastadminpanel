<?php

namespace App\Models;

use App\FiltersSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MultilanguageModel;
use Lang;
use DB;

class Category extends MultilanguageModel
{
    protected $table = 'categories';

    public function __construct(){
        parent::__construct();
    }

    protected static function booted(){

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', '=' , 1);
        });
    }

    public function get_menu_categories(){
        return $this::where('is_menu', 1)
        ->get();
    }

    public function get_catalog(){
        
        $all_categories = $this::orderBy('sort', 'DESC')
        ->get();

        $categories = $all_categories->where('id_categories', 0);
        
        foreach ($categories as &$category){
            $category->child = $all_categories->where('id_categories', $category->id)
            ->where('is_show', 1);
        }

        return $categories;
    }

    public function childs(){
        return $this->hasMany(Category::class, 'id_categories');
    }

    public function childrenRecursive(){
        return $this->childs()->with('childs');
    }

    public function get_subcategories_by_id($id){

        $categories = $this::find($id)->childrenRecursive()->get();
        
        $subcategories = [$id];
        foreach ($categories as $category){
            $subcategories = $this->make_subcategories($subcategories, $category);
        }

        return $subcategories;
    }

    protected function make_subcategories($subcategories, $category){
       
        $subcategories[] = $category->id;

        if (isset($category->childs) && sizeof($category->childs)){

            foreach ($category->childs as $child){
                $subcategories = $this->make_subcategories($subcategories, $child);
            }

        }

        return $subcategories;
    } 

    public function parent() {
        return $this->belongsTo(Category::class, 'id_categories')->with('parent');
    }

    public function get_parent_categories_by_id($id){
        
        $categories = $this::find($id)->parent()->get();

        return $categories;
    }

    public function make_parents($parent, $category){
       
        $parent[] = [
            'title'     => $category->title,
            'link'      => route('catalog', [$category->slug, ''], false),
        ];

        if (isset($category->parent)){
            $parent = $this->make_parents($parent, $category->parent);
        }

        return $parent;
    } 

    public function related_filters(){
        return $this->belongsToMany(Filter::class, 'categories_filters', 'id_categories', 'id_filters');
    }
    
    public function get_filter_by_category($id, FiltersSlug $checked_filters, $id_products){
        
        $filters = $this::find($id)
        ->related_filters()
        ->get();

        $filter_fields_model = new FilterField;
        $product_filter_fields = $filter_fields_model->get_products_filter_fields();

        foreach ($filters as &$filter){
            
            $filter->set_checked($checked_filters);
            
            foreach ($filter->filter_fields as $key => $filter_field) {
                
                $is_products_filter_field = $product_filter_fields->where('id_filter_fields', $filter_field->id)->pluck('id_products')->all();

                if (sizeof(array_intersect($is_products_filter_field, $id_products)) == 0){
                    $filter->filter_fields->forget($key);
                }
            }
        }


        return $filters;
    }

    public function get_category_by_slug($slug){
        return $this->where('slug', $slug)
        ->first();
    }

    public function get_category_by_id($id){
        return $this::find($id);
    }
    

}
