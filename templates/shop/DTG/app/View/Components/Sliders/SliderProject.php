<?php

namespace App\View\Components\Sliders;

use Illuminate\View\Component;

class SliderProject extends Component
{
    
    public $images;

    public function __construct($images = []){
        $this->images = $images;
    }

    public function render(){
        return view('components.sliders.slider-project');
    }
}
