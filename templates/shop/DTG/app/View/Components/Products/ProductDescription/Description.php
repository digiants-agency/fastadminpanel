<?php

namespace App\View\Components\Products\ProductDescription;

use Illuminate\View\Component;

class Description extends Component
{
    public $title;
    public $content;

    public function __construct($title = '', $content = ''){
        
        $this->title = $title;
        $this->content = $content;
    }

    public function render(){
        return view('components.products.product-description.description');
    }
}
