<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $javascript;
    
    public function __construct($meta_title = '', $meta_description = '', $meta_keywords = '', $javascript = ''){

        $this->meta_title = $meta_title;
        $this->meta_description = $meta_description;
        $this->meta_keywords = $meta_keywords;
        $this->javascript = $javascript;
    }


    public function render(){
        return view('components.layout');
    }
}
