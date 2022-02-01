<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends MultilanguageModel
{
    protected $table = 'delivery';
    

    public function get_by_slug($slug){
        return $this->where('slug', $slug)
        ->first();
    }
    
}
