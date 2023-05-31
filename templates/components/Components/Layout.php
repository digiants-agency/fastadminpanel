<?php

namespace App\View\Components;

use Convertor;
use Illuminate\View\Component;
use Illuminate\View\View;

class Layout extends Component
{
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    
    public function __construct($meta_title = '', $meta_description = '', $meta_keywords = ''){

        $this->meta_title = $meta_title;
        $this->meta_description = $meta_description;
        $this->meta_keywords = $meta_keywords;
    }


    public function render(){
        return view('components.layout');
    }
}
