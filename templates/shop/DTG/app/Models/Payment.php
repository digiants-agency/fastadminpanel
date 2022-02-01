<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends MultilanguageModel
{
    protected $table = 'payment';   

    public function get_by_slug($slug){
        return $this->where('slug', $slug)
        ->first();
    }
    
}
