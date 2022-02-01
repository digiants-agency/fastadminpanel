<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class FilterField extends MultilanguageModel
{
    protected $table = 'filter_fields';
    
    protected $appends = ['checked'];

    public function related_products(){
        return $this->belongsToMany(Product::class, 'products_filter_fields', 'id_filter_fields', 'id_products');
    }

    public function get_products_filter_fields(){
        return DB::table('products_filter_fields')->get();
    }

    public function get_id_products_filter_fields($filters){

        $previous_filter_key = '';
        $id_products_filter_fields = [];

        $all_filter_fields = $this->get();
        $product_filter_fields = $this->get_products_filter_fields();

        foreach ($filters as $filter_key => $filter){

            foreach ($filter as $key => $filter_field){
                $id_filter_field = $all_filter_fields->where('slug', $filter_field)
                ->first();

                if (empty($id_filter_field))
                    abort(404);
                
                $filters[$filter_key][$key] = $product_filter_fields->where('id_filter_fields', $id_filter_field->id)->pluck('id_products');

                $filters[$filter_key][0] = $filters[$filter_key][0]->merge($filters[$filter_key][$key])->unique();

                if ($key != 0){
                    unset($filters[$filter_key][$key]);
                }

            }

            $filters[$filter_key] = $filters[$filter_key][0];

            
            if (!empty($previous_filter_key)){
                $id_products_filter_fields = $filters[$filter_key]->intersect($filters[$previous_filter_key]);
            } else {
                $id_products_filter_fields = $filters[$filter_key];
            }

            $previous_filter_key = $filter_key;
        }

        return $id_products_filter_fields;

    }

    public function get_filter_fields_by_products($products){
        return $this->related_products()->get();
    }

    protected static function booted(){

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('title', 'ASC');
        });

    }
}
