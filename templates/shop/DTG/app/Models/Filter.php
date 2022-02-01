<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Filter extends MultilanguageModel
{
    protected $table = 'filters';

    public function __construct(){
        parent::__construct();
    }

    public function filter_fields(){
        return $this->hasMany(FilterField::class, 'id_filters');
    }

    protected static function booted(){

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', '=' , 1);
        });

        static::addGlobalScope('filter_fields', function (Builder $builder) {
            $builder->with('filter_fields')
            ->orderBy('sort', 'DESC');
        });
    }

    public function set_checked($checked_filters) {

        foreach($this->filter_fields as &$filter_field){

            $filter_field->checked = $checked_filters->is_checked($this->slug, $filter_field->slug);
            
        }
    }
}
