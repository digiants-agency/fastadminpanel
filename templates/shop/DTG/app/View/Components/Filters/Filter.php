<?php

namespace App\View\Components\Filters;

use Illuminate\View\Component;

class Filter extends Component
{
    public $filter; 

    public function __construct($filter = []){
        $this->filter = $filter;
    }

    public function render(){
        return view('components.filters.filter');
    }
}
