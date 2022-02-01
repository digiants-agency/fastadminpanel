<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;
use App\Scopes\ActiveScope;

class MultilanguageModel extends Model
{
    
    public function __construct(){
        
        parent::__construct();
        
        $this->table .= '_'.Lang::get(); 
    }

}
