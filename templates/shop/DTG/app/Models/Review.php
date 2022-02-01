<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    protected $table = 'reviews';
    
    public function __construct(){
        parent::__construct();
    }

    protected static function booted(){

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', '=' , 1);
        });
    }
}
