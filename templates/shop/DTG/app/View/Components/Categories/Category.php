<?php

namespace App\View\Components\Categories;

use Illuminate\View\Component;

class Category extends Component
{
    
    public $category;

    public function __construct($category = []){
        $this->category = $category; 
    }

    public function render(){
        return view('components.categories.category');
    }
}
