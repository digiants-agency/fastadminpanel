<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandartPage extends MultilanguageModel
{
    protected $table = 'standart';

    public function get_by_slug($slug){
        return $this::where('slug', $slug)
        ->first();
    }
    
}
