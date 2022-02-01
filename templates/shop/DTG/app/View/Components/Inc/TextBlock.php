<?php

namespace App\View\Components\Inc;

use Illuminate\View\Component;

class TextBlock extends Component
{
    
    public $type;
    public $content;
    public $button;
    public $image;


    public function __construct($type = "default", $content = '', $button = '', $image = ''){

        $this->type = $type;
        $this->content = $content;
        $this->button = $button;
        $this->image = $image;
    }

    
    public function render(){
        return view('components.inc.text-block');
    }
}
