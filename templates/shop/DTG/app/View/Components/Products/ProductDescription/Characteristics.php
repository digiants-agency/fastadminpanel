<?php

namespace App\View\Components\Products\ProductDescription;

use Illuminate\View\Component;

class Characteristics extends Component
{
    public $title;
    public $characteristics;

    public function __construct($title = '', $characteristics = []){

        $this->title = $title;
        $this->characteristics = $characteristics;
    }

    public function render(){
        return view('components.products.product-description.characteristics');
    }
}
